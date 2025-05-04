@extends('layouts.gerant')

@section('title', 'Gestion des Réservations')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Gestion des Réservations</h2>
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
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Heure</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Personnes</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($reservations as $reservation)
                    @php
                        // Options de style en fonction du statut de la réservation
                        switch($reservation->status) {
                            case 'en attente':
                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                break;
                            case 'confirmée':
                                $statusClass = 'bg-green-100 text-green-800';
                                break;
                            case 'annulée':
                                $statusClass = 'bg-red-100 text-red-800';
                                break;
                            default:
                                $statusClass = 'bg-gray-100 text-gray-800';
                        }
                    @endphp
                    <tr>
                        <td class="py-4 px-4">{{ $reservation->client->name ?? 'Client inconnu' }}</td>
                        <td class="py-4 px-4">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</td>
                        <td class="py-4 px-4">{{ $reservation->heure }}</td>
                        <td class="py-4 px-4">{{ $reservation->nombre_personnes }}</td>
                        <td class="py-4 px-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            @if($reservation->status === 'en attente')
                                <form action="{{ route('gerant.reservations.confirm', $reservation) }}" method="POST" onsubmit="return confirm('Confirmer cette réservation ?');">
                                    @csrf
                                    <button type="submit" class="bg-restaurant-gold text-white px-4 py-2 rounded hover:bg-opacity-90 transition">
                                        Confirmer
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">Aucune action</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
