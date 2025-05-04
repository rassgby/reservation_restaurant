@extends('layouts.client')

@section('title', 'Dashboard Client')

@section('content')
<div class="container mx-auto px-4">
    <!-- Affichage des messages de session -->
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

    <!-- Onglets de navigation -->
    <div class="mb-8 border-b border-gray-200">
        <div class="flex flex-wrap -mb-px">
            <button id="tab-reservation" class="tab-button text-restaurant-gold border-restaurant-gold inline-block p-4 border-b-2 font-medium">
                <i class="fas fa-calendar-plus mr-2"></i>Réserver une table
            </button>
            <button id="tab-availability" class="tab-button text-gray-500 hover:text-restaurant-gold inline-block p-4 border-b-2 border-transparent hover:border-restaurant-gold/50 font-medium">
                <i class="fas fa-search mr-2"></i>Vérifier les disponibilités
            </button>
            <button id="tab-history" class="tab-button text-gray-500 hover:text-restaurant-gold inline-block p-4 border-b-2 border-transparent hover:border-restaurant-gold/50 font-medium">
                <i class="fas fa-history mr-2"></i>Historique des réservations
            </button>
        </div>
    </div>

    <!-- Onglet Réservation -->
    <div id="content-reservation" class="tab-content active">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-serif font-bold mb-6">Réserver une table</h3>
            <form method="POST" action="{{ route('client.reservation.store') }}" id="reservation">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="reservation_date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                        <input type="date" id="reservation_date" name="reservation_date" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label for="reservation_time" class="block text-gray-700 text-sm font-bold mb-2">Heure</label>
                        <select id="reservation_time" name="reservation_time" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
                            <option value="">Sélectionnez une heure</option>
                            <optgroup label="Déjeuner">
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                            </optgroup>
                            <optgroup label="Dîner">
                                <option value="19:00">19:00</option>
                                <option value="19:30">19:30</option>
                                <option value="20:00">20:00</option>
                                <option value="20:30">20:30</option>
                                <option value="21:00">21:00</option>
                                <option value="21:30">21:30</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="guests" class="block text-gray-700 text-sm font-bold mb-2">Nombre de personnes</label>
                    <select id="guests" name="guests" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
                        <option value="">Sélectionnez le nombre de personnes</option>
                        @for($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                        @endfor
                        <option value="11">Plus de 10 personnes (nous contacter)</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="special_requests" class="block text-gray-700 text-sm font-bold mb-2">Demandes spéciales (optionnel)</label>
                    <textarea id="special_requests" name="special_requests" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" placeholder="Allergies, occasion spéciale, préférences..."></textarea>
                </div>
                <button type="submit" class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
                    Confirmer la réservation
                </button>
            </form>
        </div>
    </div>

    <!-- Onglet Vérifier les disponibilités -->
    <div id="content-availability" class="tab-content">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-serif font-bold mb-6">Vérifier les disponibilités</h3>
            <form method="POST" action="{{ route('client.availability.check') }}" id="availability-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="check_date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                        <input type="date" id="check_date" name="check_date" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label for="check_time" class="block text-gray-700 text-sm font-bold mb-2">Heure</label>
                        <select id="check_time" name="check_time" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
                            <option value="">Sélectionnez une heure</option>
                            <optgroup label="Déjeuner">
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                            </optgroup>
                            <optgroup label="Dîner">
                                <option value="19:00">19:00</option>
                                <option value="19:30">19:30</option>
                                <option value="20:00">20:00</option>
                                <option value="20:30">20:30</option>
                                <option value="21:00">21:00</option>
                                <option value="21:30">21:30</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label for="check_guests" class="block text-gray-700 text-sm font-bold mb-2">Nombre de personnes</label>
                        <select id="check_guests" name="check_guests" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold" required>
                            <option value="">Sélectionnez le nombre</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                            @endfor
                            <option value="11">Plus de 10 personnes</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
                    Vérifier la disponibilité
                </button>
            </form>
            <div id="availability-result" class="mt-6"></div>
        </div>
    </div>

    <!-- Onglet Historique -->
    <div id="content-history" class="tab-content">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-serif font-bold mb-6">Historique de vos réservations</h3>
            @if($reservations->isEmpty())
                <div class="bg-gray-50 p-6 text-center rounded-lg">
                    <i class="fas fa-calendar-xmark text-gray-400 text-4xl mb-3"></i>
                    <p class="text-gray-600">Vous n'avez pas encore effectué de réservation.</p>
                    <button id="history-make-reservation" class="mt-4 inline-block px-6 py-2 bg-restaurant-gold text-restaurant-dark rounded-full btn-gold hover:text-white transition">
                        Faire une première réservation
                    </button>
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
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Gestion des onglets
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => {
                btn.classList.remove('text-restaurant-gold', 'border-restaurant-gold');
                btn.classList.add('text-gray-500', 'border-transparent');
            });
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            button.classList.add('text-restaurant-gold', 'border-restaurant-gold');
            button.classList.remove('text-gray-500', 'border-transparent');
            const tabId = button.id.replace('tab-', '');
            document.getElementById('content-' + tabId).classList.add('active');
        });
    });

    // Lien "Faire une première réservation"
    document.getElementById('history-make-reservation')?.addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('tab-reservation').click();
    });

    // Définir la date minimum pour les inputs de type date
    const dateInputs = document.querySelectorAll('input[type="date"]');
    const today = new Date().toISOString().split('T')[0];
    dateInputs.forEach(input => {
        input.setAttribute('min', today);
    });

    // Exemple d'appel AJAX pour la vérification de disponibilité
    const availabilityForm = document.getElementById('availability-form');
    if(availabilityForm) {
        availabilityForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(availabilityForm);
            fetch("{{ route('client.availability.check') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const resultDiv = document.getElementById('availability-result');
                if(data.status === 'success'){
                    resultDiv.innerHTML = `<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        <strong>Disponible!</strong> ${data.message}
                    </div>`;
                } else {
                    resultDiv.innerHTML = `<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        <strong>Désolé!</strong> ${data.message}
                    </div>`;
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    }
</script>
@endsection
