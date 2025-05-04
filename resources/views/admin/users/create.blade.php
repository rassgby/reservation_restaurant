@extends('layouts.admin')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Créer un Utilisateur</h2>

    <form method="POST" action="{{ route('admin.users.store') }}" class="bg-white rounded-lg shadow-lg p-8">
        @csrf

        <div class="mb-6">
            <label for="prenom" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
            <input type="text" name="prenom" id="prenom"
                   value="{{ old('prenom') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('prenom') border-red-500 @enderror">
            @error('prenom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
            <input type="text" name="nom" id="nom"
                   value="{{ old('nom') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('nom') border-red-500 @enderror">
            @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="email"
                   value="{{ old('email') }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('email') border-red-500 @enderror">
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
            <input type="password" name="password" id="password"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('password') border-red-500 @enderror">
            @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
        </div>

        <div class="mb-6">
            <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
            <select name="type" id="type"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('type') border-red-500 @enderror">
                <option value="">-- Choisir un rôle --</option>
                <option value="client"        {{ old('type')=='client' ? 'selected' : '' }}>Client</option>
                <option value="agent"         {{ old('type')=='agent'  ? 'selected' : '' }}>Agent</option>
                <option value="administrateur"{{ old('type')=='administrateur' ? 'selected' : '' }}>Administrateur</option>
            </select>
            @error('type')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Enregistrer
        </button>
    </form>
</div>
@endsection
