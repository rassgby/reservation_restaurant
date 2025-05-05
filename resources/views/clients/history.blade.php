@extends('layouts.client')

@section('title', 'Historique des Réservations')

@section('styles')
    <style>
        .bg-restaurant-header {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), url('/api/placeholder/1200/400');
            background-size: cover;
            background-position: center;
        }

        .section-title {
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            width: 60%;
            height: 3px;
            background-color: #D4AF37;
            bottom: -10px;
            left: 0;
        }

        .btn-gold {
            background-color: #D4AF37;
            transition: all 0.3s ease;
        }

        .btn-gold:hover {
            background-color: #B8860B;
            transform: translateY(-2px);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            transition: all 0.2s ease;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .reservation-table tr {
            transition: background-color 0.2s ease;
        }

        .reservation-table tr:hover {
            background-color: rgba(212, 175, 55, 0.05);
        }

        .action-button {
            transition: all 0.2s ease;
        }

        .action-button:hover {
            transform: translateY(-1px);
            filter: brightness(1.1);
        }
    </style>
@endsection

@section('content')
    <!-- Header Banner -->
    <div class="bg-restaurant-header py-12 mb-10">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-white text-center mb-2">Vos Réservations</h1>
            <p class="text-white text-center text-lg opacity-90">Consultez et gérez l'historique de vos visites</p>
            <div class="flex justify-center mt-6">
                <a href="{{ route('client.reservation.page') }}"
                    class="inline-flex items-center px-6 py-3 bg-restaurant-gold text-white rounded-lg font-bold btn-gold hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"
                        class="mr-2">
                        <path
                            d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                    Nouvelle réservation
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-16">
        <div class="flex items-center justify-between mb-8">
            <h2 class="section-title text-3xl font-serif font-bold">Historique de vos réservations</h2>
            <div class="flex items-center space-x-2 text-sm">
                <span class="flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                    Confirmée
                </span>
                <span class="flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800">
                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                    Annulée
                </span>
                <span class="flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                    <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                    Terminée
                </span>
            </div>
        </div>

        @if($reservations->isEmpty())
            <div class="bg-white border border-gray-100 rounded-xl p-12 text-center shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#D4AF37" viewBox="0 0 16 16">
                        <path
                            d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                </div>
                <h3 class="font-serif text-2xl font-bold mb-4">Aucune réservation trouvée</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-8">Vous n'avez pas encore effectué de réservation dans notre
                    établissement. Nous serions ravis de vous accueillir prochainement.</p>
                <a href="{{ route('client.reservation.page') }}"
                    class="inline-flex items-center px-8 py-3 bg-restaurant-gold text-white rounded-lg font-bold btn-gold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"
                        class="mr-2">
                        <path
                            d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                        <path
                            d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                    Réserver une table
                </a>
            </div>
        @else
            <!-- Réservations à venir -->
            @php
                $futureReservations = $reservations->filter(function ($reservation) {
                    $reservationDatetime = new \DateTime($reservation->date . ' ' . $reservation->heure);
                    $now = new \DateTime();
                    return $reservationDatetime > $now && $reservation->status == 'confirmée';
                });
            @endphp

            @if($futureReservations->count() > 0)
                <div class="mb-12">
                    <h3 class="text-xl font-serif font-bold mb-4 border-l-4 border-restaurant-gold pl-3">Réservations à venir</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($futureReservations as $reservation)
                            @php
                                $reservationDatetime = new \DateTime($reservation->date . ' ' . $reservation->heure);
                                $now = new \DateTime();
                                $diff = $now->diff($reservationDatetime);
                                $hours = $diff->days * 24 + $diff->h;
                                $can_cancel = $hours >= 24 && $reservation->status != 'annulée';
                                $formattedDate = \Carbon\Carbon::parse($reservation->date)->locale('fr')->isoFormat('dddd D MMMM YYYY');
                            @endphp
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 card-hover">
                                <div class="bg-restaurant-gold text-white px-4 py-2 flex justify-between items-center">
                                    <span class="font-bold">{{ $formattedDate }}</span>
                                    <span class="px-2 py-1 bg-white text-restaurant-gold rounded-full text-xs font-semibold">À
                                        venir</span>
                                </div>
                                <div class="p-5">
                                    <div class="flex justify-between mb-4">
                                        <div>
                                            <p class="text-gray-500 text-sm">Heure d'arrivée</p>
                                            <p class="font-bold">{{ $reservation->heure }}</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500 text-sm">Personnes</p>
                                            <p class="font-bold">{{ $reservation->nombre_personnes }}
                                                {{ $reservation->nombre_personnes > 1 ? 'personnes' : 'personne' }}</p>
                                        </div>
                                    </div>

                                    @if($reservation->special_requests)
                                        <div class="mb-4">
                                            <p class="text-gray-500 text-sm">Demandes spéciales</p>
                                            <p class="text-gray-800">{{ $reservation->special_requests }}</p>
                                        </div>
                                    @endif

                                    <div class="flex justify-end mt-4">
                                        @if($can_cancel)
                                            <form action="{{ route('client.reservation.cancel') }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                                @csrf
                                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                <button type="submit"
                                                    class="flex items-center text-red-600 hover:text-red-800 action-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                        viewBox="0 0 16 16" class="mr-1">
                                                        <path
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                    Annuler la réservation
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500 text-sm italic flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    viewBox="0 0 16 16" class="mr-1">
                                                    <path
                                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                </svg>
                                                Annulation impossible à moins de 24h
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tableau complet des réservations -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-serif font-bold text-xl">Toutes vos réservations</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full reservation-table">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                                </th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure
                                </th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Personnes</th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Demandes</th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reservations as $reservation)
                                @php
                                    $reservationDatetime = new \DateTime($reservation->date . ' ' . $reservation->heure);
                                    $now = new \DateTime();
                                    $is_future = $reservationDatetime > $now;
                                    $diff = $now->diff($reservationDatetime);
                                    $hours = $diff->days * 24 + $diff->h;
                                    $can_cancel = $is_future && $hours >= 24 && $reservation->status != 'annulée';
                                    $formattedDate = \Carbon\Carbon::parse($reservation->date)->format('d/m/Y');

                                    switch ($reservation->status) {
                                        case 'confirmée':
                                            $statusText = 'Confirmée';
                                            $statusClass = 'bg-green-100 text-green-800';
                                            $statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="mr-1"><path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/></svg>';
                                            break;
                                        case 'annulée':
                                            $statusText = 'Annulée';
                                            $statusClass = 'bg-red-100 text-red-800';
                                            $statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="mr-1"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>';
                                            break;
                                        case 'terminée':
                                            $statusText = 'Terminée';
                                            $statusClass = 'bg-blue-100 text-blue-800';
                                            $statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="mr-1"><path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/></svg>';
                                            break;
                                        default:
                                            $statusText = 'Inconnue';
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            $statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="mr-1"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>';
                                            break;
                                    }
                                @endphp
                                <tr class="{{ $reservation->status == 'annulée' ? 'bg-gray-50 text-gray-500' : '' }}">
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $formattedDate }}</span>
                                            @if($is_future && $reservation->status == 'confirmée')
                                                <span class="text-xs text-green-600 font-medium mt-1">(À venir)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">{{ $reservation->heure }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                viewBox="0 0 16 16" class="mr-2 text-gray-400">
                                                <path
                                                    d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                                            </svg>
                                            {{ $reservation->nombre_personnes }}
                                            {{ $reservation->nombre_personnes > 1 ? 'personnes' : 'personne' }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 max-w-xs truncate">
                                        @if($reservation->special_requests)
                                            <div class="flex items-start">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    viewBox="0 0 16 16" class="mr-2 text-gray-400 mt-1 flex-shrink-0">
                                                    <path
                                                        d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                    <path
                                                        d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                                </svg>
                                                <span>{{ $reservation->special_requests }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-400">Aucune</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full status-badge {{ $statusClass }}">
                                            {!! $statusIcon !!} {{ $statusText }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($can_cancel)
                                            <form action="{{ route('client.reservation.cancel') }}" method="POST"
                                                onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');"
                                                class="inline">
                                                @csrf
                                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-50 text-red-700 border border-red-100 rounded-lg hover:bg-red-100 action-button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                        viewBox="0 0 16 16" class="mr-1">
                                                        <path
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                    Annuler
                                                </button>
                                            </form>
                                        @elseif($is_future && $reservation->status == 'confirmée')
                                            <span class="inline-flex items-center text-gray-500 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                    viewBox="0 0 16 16" class="mr-1">
                                                    <path
                                                        d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
                                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
                                                </svg>
                                                Moins de 24h
                                            </span>
                                        @elseif($reservation->status == 'terminée')
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                                    viewBox="0 0 16 16" class="mr-1">
                                                    <path
                                                        d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z" />
                                                    <path
                                                        d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                                                </svg>
                                                Complétée
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 bg-gray-50 p-6 rounded-xl border border-gray-100 shadow-sm">
                <h4 class="font-serif font-bold text-lg mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#D4AF37" viewBox="0 0 16 16"
                        class="mr-2">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg>
                    Politique d'annulation
                </h4>
                <p class="text-gray-600 mb-3">Pour garantir la qualité de notre service, nous vous demandons de respecter les
                    règles suivantes:</p>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#D4AF37" viewBox="0 0 16 16"
                            class="mr-2 mt-1 flex-shrink-0">
                            <path
                                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                        </svg>
                        <span>Les annulations sont <strong>possibles jusqu'à 24 heures</strong> avant l'heure de votre
                            réservation.</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#D4AF37" viewBox="0 0 16 16"
                            class="mr-2 mt-1 flex-shrink-0">
                            <path
                                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                        </svg>
                        <span>Passé ce délai, nous vous invitons à nous contacter directement par téléphone en cas
                            d'empêchement.</span>
                    </li>
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#D4AF37" viewBox="0 0 16 16"
                            class="mr-2 mt-1 flex-shrink-0">
                            <path
                                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                        </svg>
                        <span>Les réservations non honorées sans annulation préalable peuvent entraîner des restrictions pour
                            les réservations futures.</span>
                    </li>
                </ul>
            </div>
        @endif
    </div>

    <div class="fixed bottom-6 right-6">
        <a href="{{ route('client.reservation.page') }}"
            class="flex items-center justify-center w-14 h-14 bg-restaurant-gold text-white rounded-full shadow-lg hover:bg-yellow-600 transition-all transform hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z" />
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
            </svg>
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animation for cards
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
                });
                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
                });
            });

            // Highlight table rows on hover
            const tableRows = document.querySelectorAll('.reservation-table tr');
            tableRows.forEach(row => {
                if (!row.classList.contains('bg-gray-50')) {
                    row.addEventListener('mouseenter', function () {
                        this.style.backgroundColor = 'rgba(212, 175, 55, 0.05)';
                    });
                    row.addEventListener('mouseleave', function () {
                        this.style.backgroundColor = '';
                    });
                }
            });

            // Action buttons animation
            const actionButtons = document.querySelectorAll('.action-button');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-1px)';
                    this.style.filter = 'brightness(1.1)';
                });
                button.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.filter = 'brightness(1)';
                });
            });
        });
    </script>
@endsection