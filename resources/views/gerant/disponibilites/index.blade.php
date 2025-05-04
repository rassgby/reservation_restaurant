@extends('layouts.gerant')

@section('title', 'Gestion des Disponibilités')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Gestion des Disponibilités</h2>
    <a href="{{ route('gerant.disponibilites.create') }}"
       class="mb-4 inline-block bg-restaurant-gold text-restaurant-dark px-4 py-2 rounded hover:bg-opacity-90 transition">
       Ajouter une disponibilité
    </a>
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            {{ session('error') }}
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Capacité Totale</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Places Réservées</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($disponibilites as $dispo)
                    <tr>
                        <td class="py-4 px-4">{{ \Carbon\Carbon::parse($dispo->date)->format('d/m/Y') }}</td>
                        <td class="py-4 px-4">{{ $dispo->heure }}</td>
                        <td class="py-4 px-4">{{ $dispo->capacite_totale }}</td>
                        <td class="py-4 px-4">{{ $dispo->places_reservees }}</td>
                        <td class="py-4 px-4">
                            <a href="{{ route('gerant.disponibilites.edit', $dispo) }}"
                               class="text-blue-600 hover:text-blue-800 mr-2">
                               Modifier
                            </a>
                            <form action="{{ route('gerant.disponibilites.destroy', $dispo) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Supprimer cette disponibilité ?');">
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
</div>
@endsection
