@extends('layouts.client')

@section('title', 'Réserver une Table')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Réserver une table</h2>
    <form method="POST" action="{{ route('client.reservation.store') }}" id="reservation">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" id="date" name="date"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                    min="{{ date('Y-m-d') }}" required>
            </div>
            <div>
                <label for="heure" class="block text-gray-700 text-sm font-bold mb-2">Heure</label>
                <select id="heure" name="heure"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                    required>
                    <option value="">Sélectionnez une heure</option>
                    <optgroup label="Déjeuner">
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                        <option value="14:00">14:00</option>
                    </optgroup>
                    <optgroup label="Dîner">
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="mb-6">
            <label for="nombre_personnes" class="block text-gray-700 text-sm font-bold mb-2">Nombre de personnes</label>
            <select id="nombre_personnes" name="nombre_personnes"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                required>
                <option value="">Sélectionnez le nombre de personnes</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                @endfor
                <option value="11">Plus de 10 personnes (nous contacter)</option>
            </select>
        </div>
        <div class="mb-6">
            <label for="special_requests" class="block text-gray-700 text-sm font-bold mb-2">Demandes spéciales (optionnel)</label>
            <textarea id="special_requests" name="special_requests" rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                placeholder="Allergies, occasion spéciale, préférences..."></textarea>
        </div>
        <button type="submit"
            class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Confirmer la réservation
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Définir la date minimum pour l'input date
    const dateInput = document.getElementById('date');
    if (dateInput) {
        dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
    }
</script>
@endsection
