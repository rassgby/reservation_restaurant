@extends(
    auth()->user()->type === 'gerant'
      ? 'layouts.gerant'
      : (auth()->user()->type === 'administrateur'
          ? 'layouts.admin'
          : 'layouts.client')
)



@section('title','Mon Profil')

@section('content')
<div class="container mx-auto px-4 max-w-xl">
    <h2 class="text-3xl font-serif font-bold mb-6">Mon Profil</h2>

    @if (session('status') == 'profile-updated')
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            Informations mises à jour.
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="bg-white rounded-lg shadow-lg p-8 mb-8">
        @csrf
        @method('PATCH')

        <div class="mb-6">
            <label for="prenom" class="block text-gray-700 text-sm font-bold mb-1">Prénom</label>
            <input id="prenom" name="prenom" type="text"
                   value="{{ old('prenom', auth()->user()->prenom) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('prenom') border-red-500 @enderror">
            @error('prenom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="nom" class="block text-gray-700 text-sm font-bold mb-1">Nom</label>
            <input id="nom" name="nom" type="text"
                   value="{{ old('nom', auth()->user()->nom) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('nom') border-red-500 @enderror">
            @error('nom')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-1">Email</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', auth()->user()->email) }}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('email') border-red-500 @enderror">
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit"
                class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Mettre à jour mes informations
        </button>
    </form>

    <h2 class="text-3xl font-serif font-bold mb-6">Changer mon mot de passe</h2>

    @if (session('status') == 'password-updated')
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            Mot de passe mis à jour.
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}" class="bg-white rounded-lg shadow-lg p-8">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="current_password" class="block text-gray-700 text-sm font-bold mb-1">Mot de passe actuel</label>
            <input id="current_password" name="current_password" type="password" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('current_password') border-red-500 @enderror">
            @error('current_password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-1">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold @error('password') border-red-500 @enderror">
            @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-1">Confirmer mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
        </div>

        <button type="submit"
                class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Mettre à jour mon mot de passe
        </button>
    </form>
</div>
@endsection
