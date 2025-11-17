<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

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
        return redirect()->route('reservations.create');
    }

    /**
     * Display the specified resource.
     */
    public function success(Reservation $reservation)
    {
        return view('reservation.success', ['reservation' => $reservation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }
}
