@extends('layouts.gerant')

@section('title', 'Détail du Plat')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Détail du Plat</h2>
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-2xl font-bold mb-2">{{ $menu->nom_plat }}</h3>
        <p class="mb-2"><strong>Prix :</strong> {{ number_format($menu->prix, 2, ',', ' ') }} FCFA</p>
        <p class="mb-2"><strong>Description :</strong> {{ $menu->description }}</p>
        <p class="mb-2"><strong>Jour :</strong> {{ $menu->jour }}</p>
        <p class="mb-2"><strong>Catégorie :</strong> {{ ucfirst($menu->categorie) }}</p>
    </div>
    <a href="{{ route('gerant.menus.index') }}" class="mt-4 inline-block bg-restaurant-gold text-restaurant-dark px-4 py-2 rounded hover:bg-opacity-90 transition">
        Retour à la liste
    </a>
</div>
@endsection
