@extends('layouts.gerant')

@section('title', 'Ajouter un Plat')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Ajouter un Plat</h2>
    <form method="POST" action="{{ route('gerant.menus.store') }}">
        @csrf
        <div class="mb-4">
            <label for="nom_plat" class="block text-gray-700 text-sm font-bold mb-2">Nom du Plat</label>
            <input type="text" id="nom_plat" name="nom_plat" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
        </div>
        <div class="mb-4">
            <label for="prix" class="block text-gray-700 text-sm font-bold mb-2">Prix</label>
            <input type="number" step="0.01" id="prix" name="prix" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required></textarea>
        </div>
        <div class="mb-4">
            <label for="jour" class="block text-gray-700 text-sm font-bold mb-2">Jour</label>
            <input type="text" id="jour" name="jour" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" placeholder="ex: Lundi" required>
        </div>
        <div class="mb-4">
            <label for="categorie" class="block text-gray-700 text-sm font-bold mb-2">Catégorie</label>
            <select id="categorie" name="categorie" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
                <option value="">Choisissez une catégorie</option>
                <option value="entrees">Entrées</option>
                <option value="plat">Plat</option>
                <option value="dessert">Dessert</option>
            </select>
        </div>
        <button type="submit" class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Enregistrer le Plat
        </button>
    </form>
</div>
@endsection
