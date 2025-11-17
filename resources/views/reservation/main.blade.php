<x-layout.reservation>
    <form class="w-full max-w-[500px] min-h-[30px] dark:bg-stone-800 bg-stone-50 flex rounded-lg p-4 flex-col gap-4"
        action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <h1 class="text-2xl">Reserveer je bezoek</h1>
        <div>
            <label for="datum">Datum<span class="text-red-400">*</span></label>
            <input type="text" id="datum" name="datum" placeholder="Kies een datum" class="border border-gray-500 rounded px-3 py-2 w-full mt-1" required>
        </div>
        <div>
            <label for="">Tijdslot<span class="text-red-400">*</span></label>
            <select id="timeslot" name="timeslot" class="border border-gray-500 rounded px-3 py-2 w-full mt-1 bg-stone-50 dark:bg-stone-800" required>
                @foreach ($timeslots as $slot)
                    <option value="{{ $slot }}">{{ $slot }}</option>
                @endforeach
            </select>
        </div>      
        <div>
            <h1 class="text-xl">Bezoekers</h1>

            <div id="holder-visitors">
                <script type="text/template" id="visitor-template">
                    {!! view('components.visitor-form', ['visitorID' => '__ID__'])->render() !!}
                </script>
            </div>

        <button id="add-visitor-btn" type="button" class="bg-stone-300 dark:bg-stone-700 px-3 py-1 rounded hover:dark:bg-stone-600 hover:bg-stone-400 mt-2">
            Voeg een bezoeker toe
        </button>
        </div>


        <div class="flex justify-end mt-2">
            <button type="submit" class="bg-stone-300 dark:bg-stone-700 px-4 py-2 rounded hover:dark:bg-stone-600 hover:bg-stone-400">
                Reserveer
            </button>
        </div>

    </form>

    <script>
document.addEventListener("DOMContentLoaded", () => {
    flatpickr("#datum", { dateFormat: "Y-m-d", minDate: "today" });

    let visitorCount = 0;
    const holder = document.getElementById("holder-visitors");
    const addVisitorBtn = document.querySelector("#add-visitor-btn");

    addVisitorBtn.addEventListener("click", () => {
        visitorCount++;

        const template = document.getElementById("visitor-template").innerHTML;
        const html = template.replace(/__ID__/g, visitorCount);

        holder.insertAdjacentHTML("beforeend", html);

        initializeVisitor(visitorCount);
    });

    function initializeVisitor(id) {
        const input = document.getElementById(`subscription-${id}`);
        const msg = document.getElementById(`submsg-${id}`);

        input.addEventListener("input", () => validateSubscription(input, msg));
        document
            .querySelector(`#visitor-${id} .delete-visitor`)
            .addEventListener("click", () => {
                document.getElementById(`visitor-${id}`).remove();
            });
    }

    function validateSubscription(input, msg) {
        const digits = input.value.replace(/[^0-9]/g, "").slice(0, 10);
        let formatted = digits;

        if (formatted.length > 4) formatted = formatted.slice(0, 4) + "-" + formatted.slice(4);
        if (formatted.length > 8) formatted = formatted.slice(0, 9) + "-" + formatted.slice(9);

        input.value = formatted;

        if (digits.length < 10) {
            return setInvalid(input, msg, "Abonnementsnummer moet 10 cijfers bevatten.");
        }

        const first8 = Number(digits.slice(0, 8));
        const last2 = Number(digits.slice(8, 10));

        if (first8 % 97 !== last2) {
            return setInvalid(input, msg, "Checksum ongeldig. Controleer het nummer.");
        }

        return setValid(input, msg, "Geldig abonnementsnummer.");
    }

    function setInvalid(input, msg, text) {
        input.classList.add("border-red-500");
        input.classList.remove("border-green-500");
        msg.textContent = text;
        msg.classList.remove("text-green-500");
        msg.classList.add("text-red-400");
    }

    function setValid(input, msg, text) {
        input.classList.remove("border-red-500");
        input.classList.add("border-green-500");
        msg.textContent = text;
        msg.classList.remove("text-red-400");
        msg.classList.add("text-green-500");
    }
});
</script>
</x-layout.reservation>