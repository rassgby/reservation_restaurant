@extends('layouts.admin')

@section('title', 'Dashboard Administrateur')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-4">Tableau de bord Administrateur</h2>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium">Utilisateurs</h3>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium">Utilisateurs actifs</h3>
            <p class="text-2xl font-bold">{{ $activeUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium">Réservations totales</h3>
            <p class="text-2xl font-bold">{{ $totalReservations }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium">Réservations en attente</h3>
            <p class="text-2xl font-bold">{{ $pendingReservations }}</p>
        </div>
    </div>

    <div class="mb-8">
        <h3 class="text-2xl font-serif font-bold mb-3">Disponibilités à venir</h3>
        <ul class="space-y-2">
            @foreach($disponibilites as $d)
                <li class="bg-white p-4 rounded-lg shadow flex justify-between items-center">
                    <span>
                        {{ \Carbon\Carbon::parse($d->date)->format('d/m/Y') }} à {{ $d->heure }}
                    </span>
                    <span class="font-bold">
                        {{ $d->placesRestantes() }} places restantes
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
