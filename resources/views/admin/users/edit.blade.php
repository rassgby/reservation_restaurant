@extends('layouts.admin')

@section('title', 'Modifier un Utilisateur')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Modifier un Utilisateur</h2>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-lg shadow-lg p-8">
        @csrf
        @method('PATCH')

        <div class="mb-6">
            <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
            <input type="text" name="prenom" id="prenom"
                   value="{{ old('prenom', $user->prenom) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('prenom') border-red-500 @enderror">
            @error('prenom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
            <input type="text" name="nom" id="nom"
                   value="{{ old('nom', $user->nom) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('nom') border-red-500 @enderror">
            @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('email') border-red-500 @enderror">
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
            <select name="type" id="type"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('type') border-red-500 @enderror">
                <option value="client"        {{ $user->type=='client' ? 'selected' : '' }}>Client</option>
                <option value="agent"         {{ $user->type=='agent'  ? 'selected' : '' }}>Agent</option>
                <option value="administrateur"{{ $user->type=='administrateur' ? 'selected' : '' }}>Administrateur</option>
            </select>
            @error('type')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="is_active" class="block text-gray-700 text-sm font-bold mb-2">Compte actif ?</label>
            <select name="is_active" id="is_active"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <button type="submit"
                class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Mettre à jour
        </button>
    </form>
</div>
@endsection
