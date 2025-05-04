@extends('layouts.gerant')

@section('title', 'Liste des Menus')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-serif font-bold">Liste des Menus</h2>
        <a href="{{ route('gerant.menus.create') }}" class="bg-restaurant-gold text-restaurant-dark px-4 py-2 rounded hover:bg-opacity-90 transition">
            Ajouter un Plat
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($menuItems->isEmpty())
        <p>Aucun menu enregistré.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Nom du plat</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Jour</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($menuItems as $item)
                <tr>
                    <td class="py-4 px-4">{{ $item->nom_plat }}</td>
                    <td class="py-4 px-4">{{ number_format($item->prix, 2, ',', ' ') }} FCFA</td>
                    <td class="py-4 px-4">{{ $item->description }}</td>
                    <td class="py-4 px-4">{{ $item->jour }}</td>
                    <td class="py-4 px-4">{{ ucfirst($item->categorie) }}</td>
                    <td class="py-4 px-4">
                        <a href="{{ route('gerant.menus.edit', $item) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                            Modifier
                        </a>
                        <form action="{{ route('gerant.menus.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce plat ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
