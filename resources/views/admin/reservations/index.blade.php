@extends('layouts.admin')

@section('title', 'Toutes les Réservations')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Toutes les Réservations</h2>

    <form method="GET" class="flex items-center mb-6 space-x-3">
        <input type="date" name="date" value="{{ request('date') }}"
               class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
        <button type="submit"
                class="px-6 py-2 btn-gold rounded-full hover:text-white transition">
            Filtrer
        </button>
        <a href="{{ route('admin.reservations.index') }}"
           class="ml-2 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition">
            Réinitialiser
        </a>
    </form>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left font-medium">Date</th>
                    <th class="py-3 px-4 text-left font-medium">Heure</th>
                    <th class="py-3 px-4 text-left font-medium">Client</th>
                    <th class="py-3 px-4 text-left font-medium">Personnes</th>
                    <th class="py-3 px-4 text-left font-medium">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reservations as $r)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($r->date)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $r->heure }}</td>
                        <td class="py-3 px-4">
                            {{ $r->client->prenom ?? '-' }} {{ $r->client->nom ?? '' }}
                        </td>
                        <td class="py-3 px-4">{{ $r->nombre_personnes }}</td>
                        <td class="py-3 px-4">{{ ucfirst($r->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                            Aucune réservation trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reservations->hasPages())
        <div class="mt-6">
            {{ $reservations->appends(request()->only('date'))->links() }}
        </div>
    @endif
</div>
@endsection
