@extends('layouts.guest')

@section('title','Connexion')

@section('content')
<div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
  <h2 class="text-2xl font-serif font-bold text-center mb-6">Connexion</h2>
  <form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <div class="mb-4">
      <label for="email" class="block text-sm font-medium mb-1">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
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

    <div class="flex items-center justify-between mb-6">
      <label class="inline-flex items-center">
        <input type="checkbox" name="remember" class="form-checkbox h-5 w-5 text-restaurant-gold">
        <span class="ml-2 text-sm">Se souvenir de moi</span>
      </label>
      @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="text-sm text-restaurant-gold hover:underline">
          Mot de passe oublié ?
        </a>
      @endif
    </div>

    <button type="submit"
            class="w-full px-4 py-2 bg-restaurant-gold text-restaurant-dark font-semibold rounded-md hover:bg-opacity-90 transition">
      Se connecter
    </button>

    <p class="text-center text-sm text-gray-600 mt-4">
      Pas encore de compte ?
      <a href="{{ route('register') }}" class="text-restaurant-gold hover:underline">Inscription</a>
    </p>
  </form>
</div>
@endsection
