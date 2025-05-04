@extends('layouts.gerant')

@section('title', 'Modifier la Disponibilité')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Modifier la Disponibilité</h2>
    <form method="POST" action="{{ route('gerant.disponibilites.update', $disponibilite) }}">
        @csrf
        @method('PATCH')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" id="date" name="date" value="{{ $disponibilite->date }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" disabled>
            </div>
            <div>
                <label for="heure" class="block text-gray-700 text-sm font-bold mb-2">Heure</label>
                <input type="time" id="heure" name="heure" value="{{ $disponibilite->heure }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" disabled>
            </div>
            <div>
                <label for="capacite_totale" class="block text-gray-700 text-sm font-bold mb-2">Capacité Totale</label>
                <input type="number" id="capacite_totale" name="capacite_totale" value="{{ $disponibilite->capacite_totale }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" min="{{ $disponibilite->places_reservees }}" required>
            </div>
        </div>
        <div class="mb-6">
            <label for="disponible" class="block text-gray-700 text-sm font-bold mb-2">Disponible</label>
            <select id="disponible" name="disponible" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
                <option value="1" {{ $disponibilite->disponible ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ !$disponibilite->disponible ? 'selected' : '' }}>Non</option>
            </select>
        </div>
        <button type="submit" class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
