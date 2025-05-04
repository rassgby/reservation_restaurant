@extends('layouts.client')

@section('title', 'Historique des Réservations')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Historique de vos réservations</h2>
    @if($reservations->isEmpty())
        <div class="bg-gray-50 p-6 text-center rounded-lg">
            <i class="fas fa-calendar-xmark text-gray-400 text-4xl mb-3"></i>
            <p class="text-gray-600">Vous n'avez pas encore effectué de réservation.</p>
            <a href="{{ route('client.reservation.page') }}"
               class="mt-4 inline-block px-6 py-2 bg-restaurant-gold text-restaurant-dark rounded-full btn-gold hover:text-white transition">
                Faire une première réservation
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Personnes</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Demandes</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reservations as $reservation)
                        @php
                            $reservationDatetime = new \DateTime($reservation->date . ' ' . $reservation->heure);
                            $now = new \DateTime();
                            $is_future = $reservationDatetime > $now;
                            $diff = $now->diff($reservationDatetime);
                            $hours = $diff->days * 24 + $diff->h;
                            $can_cancel = $is_future && $hours >= 24 && $reservation->status != 'annulée';

                            switch ($reservation->status) {
                                case 'confirmée':
                                    $statusText = 'Confirmée';
                                    $statusClass = 'bg-green-100 text-green-800';
                                    break;
                                case 'annulée':
                                    $statusText = 'Annulée';
                                    $statusClass = 'bg-red-100 text-red-800';
                                    break;
                                case 'terminée':
                                    $statusText = 'Terminée';
                                    $statusClass = 'bg-blue-100 text-blue-800';
                                    break;
                                default:
                                    $statusText = 'Inconnue';
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    break;
                            }
                        @endphp
                        <tr class="{{ $reservation->status == 'annulée' ? 'bg-gray-50 text-gray-500' : '' }}">
                            <td class="py-4 px-4">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                @if($is_future && $reservation->status == 'confirmée')
                                    <span class="ml-2 text-xs text-green-600">(À venir)</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">{{ $reservation->heure }}</td>
                            <td class="py-4 px-4">{{ $reservation->nombre_personnes }} {{ $reservation->nombre_personnes > 1 ? 'personnes' : 'personne' }}</td>
                            <td class="py-4 px-4 max-w-xs truncate">
                                {!! $reservation->special_requests ? e($reservation->special_requests) : '<span class="text-gray-400">Aucune</span>' !!}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                @if($can_cancel)
                                    <form action="{{ route('client.reservation.cancel') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');" class="inline">
                                        @csrf
                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-800 mr-3">
                                            <i class="fas fa-times-circle"></i> Annuler
                                        </button>
                                    </form>
                                @elseif($is_future && $reservation->status == 'confirmée')
                                    <span class="text-gray-500 text-sm italic">
                                        <i class="fas fa-clock"></i> Annulation impossible
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 bg-gray-50 p-4 rounded-lg text-sm">
            <h4 class="font-semibold mb-2">À noter :</h4>
            <ul class="text-gray-600 space-y-1">
                <li><i class="fas fa-info-circle text-blue-500 mr-2"></i> Les réservations ne peuvent être annulées que 24 heures à l'avance.</li>
                <li><i class="fas fa-calendar-check text-green-500 mr-2"></i> Les réservations passées sont automatiquement marquées comme terminées.</li>
            </ul>
        </div>
    @endif
</div>
@endsection
