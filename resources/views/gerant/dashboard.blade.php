@extends('layouts.gerant')

@section('title', 'Dashboard Gérant')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Bienvenue, {{ Auth::user()->name }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-bold mb-2">Total Réservations</h3>
            <p class="text-2xl">{{ $totalReservations ?? '0' }}</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-bold mb-2">Réservations en attente</h3>
            <p class="text-2xl">{{ $pendingReservations ?? '0' }}</p>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-bold mb-2">Réservations confirmées</h3>
            <p class="text-2xl">{{ $confirmedReservations ?? '0' }}</p>
        </div>
    </div>
    <div class="mt-10">
        <h3 class="text-2xl font-bold mb-4">Disponibilités à venir</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-500 uppercase">Date</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-500 uppercase">Heure</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-500 uppercase">Capacité Totale</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-500 uppercase">Places Réservées</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($disponibilites as $dispo)
                    <tr>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($dispo->date)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $dispo->heure }}</td>
                        <td class="py-3 px-4">{{ $dispo->capacite_totale }}</td>
                        <td class="py-3 px-4">{{ $dispo->places_reservees }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
