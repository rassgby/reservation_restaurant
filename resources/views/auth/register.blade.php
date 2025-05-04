@extends('layouts.guest')

@section('title','Inscription')

@section('content')
<div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
  <h2 class="text-2xl font-serif font-bold text-center mb-6">Inscription</h2>
  <form method="POST" action="{{ route('register') }}" novalidate>
    @csrf

    <div class="mb-4">
      <label for="prenom" class="block text-sm font-medium mb-1">Prénom</label>
      <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required
             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('prenom') border-red-500 @enderror">
      @error('prenom')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="nom" class="block text-sm font-medium mb-1">Nom</label>
      <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required
             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('nom') border-red-500 @enderror">
      @error('nom')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="email" class="block text-sm font-medium mb-1">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required
             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('email') border-red-500 @enderror">
      @error('email')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-4">
      <label for="password" class="block text-sm font-medium mb-1">Mot de passe</label>
      <input id="password" type="password" name="password" required
             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('password') border-red-500 @enderror">
      @error('password')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-6">
      <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmer le mot de passe</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required
             class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
    </div>

    <button type="submit"
            class="w-full px-4 py-2 bg-restaurant-gold text-restaurant-dark font-semibold rounded-md hover:bg-opacity-90 transition">
      S’inscrire
    </button>

    <p class="text-center text-sm text-gray-600 mt-4">
      Déjà un compte ?
      <a href="{{ route('login') }}" class="text-restaurant-gold hover:underline">Connexion</a>
    </p>
  </form>
</div>
@endsection
