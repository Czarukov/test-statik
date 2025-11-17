<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Visitor;

class ReservationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $timeslots = [
            '10:00-12:00','12:00-14:00','14:00-16:00','16:00-18:00',
        ];
        
        return view('reservation.main',['timeslots' => $timeslots]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'datum'    => ['required', 'date', 'after_or_equal:today'],
            'timeslot' => ['required', 'string'],
        ];

        $visitorIDs = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^subscription-(\d+)$/', $key, $m)) {
                $visitorIDs[] = $m[1];
            }
        }

        if (empty($visitorIDs)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['visitor' => 'Je moet minstens één bezoeker toevoegen.']);
        }

        foreach ($visitorIDs as $id) {
            $rules["first-name-$id"] = ['required', 'string', 'max:255'];
            $rules["last-name-$id"]  = ['required', 'string', 'max:255'];
            $rules["subscription-$id"] = [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    // 1️⃣ Validate digits + checksum
                    $digits = preg_replace('/\D/', '', $value);
                    if (strlen($digits) !== 10) {
                        return $fail("Abonnementsnummer moet 10 cijfers bevatten.");
                    }
                    $first8 = intval(substr($digits, 0, 8));
                    $last2  = intval(substr($digits, 8, 10));
                    if ($first8 % 97 !== $last2) {
                        return $fail("Checksum ongeldig. Controleer het nummer.");
                    }

                    $exists = Visitor::where('subscription', $digits)->whereHas('reservation', function ($query) use ($request) {
                        $query->where('date', $request->input('datum'))->where('timeslot', $request->input('timeslot'));
                    })->exists();

                    if ($exists) {
                        return $fail("Deze abonnee is al geregistreerd voor deze datum en tijdslot.");
                    }
                }
            ];
        }

        $validated = $request->validate($rules);

        $reservation = Reservation::create([
            'date'     => $validated['datum'],
            'timeslot' => $validated['timeslot'],
        ]);

        $visitors = [];
        foreach ($visitorIDs as $id) {
            $visitor = Visitor::create([
                'reservation_id' => $reservation->id,
                'first_name'     => $validated["first-name-$id"],
                'last_name'      => $validated["last-name-$id"],
                'subscription'   => $validated["subscription-$id"],
            ]);
            $visitors[] = $visitor;
        }

        // Redirect with success message + extra data
        return redirect()->route('reservations.create')
            ->with('success', 'Reservering succesvol aangemaakt!')
            ->with('reservation', $reservation)
            ->with('visitor_count', count($visitors));
    }
}
