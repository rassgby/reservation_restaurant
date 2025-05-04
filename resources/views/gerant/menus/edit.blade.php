@extends('layouts.gerant')

@section('title', 'Modifier un Plat')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Modifier un Plat</h2>
    <form method="POST" action="{{ route('gerant.menus.update', $menu) }}">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="nom_plat" class="block text-gray-700 text-sm font-bold mb-2">Nom du Plat</label>
            <input type="text" id="nom_plat" name="nom_plat" value="{{ $menu->nom_plat }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
        </div>
        <div class="mb-4">
            <label for="prix" class="block text-gray-700 text-sm font-bold mb-2">Prix</label>
            <input type="number" step="0.01" id="prix" name="prix" value="{{ $menu->prix }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea id="description" name="description" rows="3"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>{{ $menu->description }}</textarea>
        </div>
        <div class="mb-4">
            <label for="jour" class="block text-gray-700 text-sm font-bold mb-2">Jour</label>
            <input type="text" id="jour" name="jour" value="{{ $menu->jour }}"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
        </div>
        <div class="mb-4">
            <label for="categorie" class="block text-gray-700 text-sm font-bold mb-2">Catégorie</label>
            <select id="categorie" name="categorie" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
                <option value="">Choisissez une catégorie</option>
                <option value="entrees" {{ $menu->categorie == 'entrees' ? 'selected' : '' }}>Entrées</option>
                <option value="plat" {{ $menu->categorie == 'plat' ? 'selected' : '' }}>Plat</option>
                <option value="dessert" {{ $menu->categorie == 'dessert' ? 'selected' : '' }}>Dessert</option>
            </select>
        </div>
        <button type="submit" class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Mettre à jour le Plat
        </button>
    </form>
</div>
@endsection
