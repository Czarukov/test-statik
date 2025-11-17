@props(['visitorID'])

<div id="visitor-{{ $visitorID }}" class="visitor-form relative w-full min-h-[30px] dark:bg-stone-700 bg-stone-100 flex rounded-lg p-4 flex-col gap-4 my-2">
    <button type="button" class="delete-visitor absolute top-1 right-1 bg-red-500 px-2 rounded"> X </button>

    <div>
        <label>Voornaam<span class="text-red-400">*</span></label>
        <input type="text" name="first-name-{{ $visitorID }}" class="border border-gray-500 rounded px-3 py-2 w-full mt-1">
    </div>

    <div>
        <label>Achternaam<span class="text-red-400">*</span></label>
        <input type="text" name="last-name-{{ $visitorID }}" class="border border-gray-500 rounded px-3 py-2 w-full mt-1">
    </div>

    <div>
        <label>Abonnementsnummer<span class="text-red-400">*</span></label>
        <input 
            type="text" 
            id="subscription-{{ $visitorID }}" 
            name="subscription-{{ $visitorID }}"
            class="subscription-input border border-gray-500 rounded px-3 py-2 w-full mt-1"
            placeholder="1234-5678-90"
            required
        >
        <p id="submsg-{{ $visitorID }}" class="text-sm mt-1"></p>
    </div>
</div>