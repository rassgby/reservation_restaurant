@extends('layouts.client')

@section('title', 'Vérifier les Disponibilités')

@section('content')
<div class="bg-white py-16">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- En-tête avec effet décoratif -->
        <div class="text-center mb-12">
            <h2 class="text-4xl font-serif font-bold text-restaurant-dark mb-3">Vérifier les Disponibilités</h2>
            <div class="flex justify-center items-center">
                <div class="h-0.5 w-16 bg-restaurant-gold"></div>
                <div class="mx-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-restaurant-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h14a2 2 0 012 2v3a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M12 3v18" />
                    </svg>
                </div>
                <div class="h-0.5 w-16 bg-restaurant-gold"></div>
            </div>
            <p class="text-gray-500 mt-3 text-lg">Réservez votre table et profitez d'une expérience gastronomique inoubliable</p>
        </div>

        <!-- Carte stylisé pour le formulaire -->
        <div class="bg-white rounded-lg shadow-lg p-8 border border-gray-100">
            <form method="POST" action="{{ route('client.availability.check') }}" id="availability-form" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Date -->
                    <div class="space-y-2">
                        <label for="check_date" class="block text-gray-700 font-medium">Date de réservation</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="check_date" name="check_date"
                                class="block w-full pl-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-restaurant-gold focus:border-restaurant-gold transition-all"
                                min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <!-- Heure -->
                    <div class="space-y-2">
                        <label for="check_time" class="block text-gray-700 font-medium">Heure de réservation</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <select id="check_time" name="check_time"
                                class="block w-full pl-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-restaurant-gold appearance-none focus:border-restaurant-gold transition-all"
                                required>
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
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nombre de personnes -->
                    <div class="space-y-2">
                        <label for="check_guests" class="block text-gray-700 font-medium">Nombre de convives</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <select id="check_guests" name="check_guests"
                                class="block w-full pl-10 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-restaurant-gold appearance-none focus:border-restaurant-gold transition-all"
                                required>
                                <option value="">Sélectionnez le nombre</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                                @endfor
                                <option value="11">Plus de 10 personnes</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bouton de soumission -->
                <div class="flex justify-center mt-6">
                    <button type="submit"
                        class="px-8 py-4 bg-restaurant-gold text-restaurant-dark rounded-full font-bold hover:bg-restaurant-gold/90 hover:text-white transform hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-restaurant-gold focus:ring-offset-2 shadow-md">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Vérifier la disponibilité</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Zone de résultat -->
        <div id="availability-result" class="mt-8"></div>
        
        <!-- Information supplémentaire -->
        <div class="mt-8 bg-gray-50 rounded-lg p-6 border border-gray-200">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-restaurant-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-900">Informations importantes</h3>
                    <div class="mt-2 text-sm text-gray-500 space-y-1">
                        <p>Pour les groupes de plus de 10 personnes, veuillez nous contacter directement par téléphone.</p>
                        <p>Les réservations en ligne sont possibles jusqu'à 2 heures avant l'heure souhaitée.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Définir la date minimum pour l'input date
    const checkDateInput = document.getElementById('check_date');
    if (checkDateInput) {
        checkDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
        // Définir la date du jour par défaut
        checkDateInput.valueAsDate = new Date();
    }

    // Appel AJAX pour vérifier la disponibilité
    const availabilityForm = document.getElementById('availability-form');
    if(availabilityForm) {
        availabilityForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Animation de chargement
            const resultDiv = document.getElementById('availability-result');
            resultDiv.innerHTML = `
                <div class="flex justify-center items-center p-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-restaurant-gold"></div>
                </div>
            `;
            
            const formData = new FormData(availabilityForm);
            fetch("{{ route('client.availability.check') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success'){
                    resultDiv.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-green-800">Disponible !</h3>
                                    <p class="mt-1 text-green-700">${data.message}</p>
                                    <div class="mt-4">
                                        <a href="?date=${formData.get('check_date')}&time=${formData.get('check_time')}&guests=${formData.get('check_guests')}" 
                                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Réserver maintenant
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6 shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-red-800">Désolé !</h3>
                                    <p class="mt-1 text-red-700">${data.message}</p>
                                    <div class="mt-4 flex flex-col sm:flex-row gap-3">
                                        <button onclick="suggestAlternative()" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                            Voir les alternatives
                                        </button>
                                        <a href="" 
                                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-restaurant-gold">
                                            Nous contacter
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Une erreur est survenue</h3>
                                <p class="mt-2 text-sm text-yellow-700">Veuillez réessayer ultérieurement ou nous contacter directement.</p>
                            </div>
                        </div>
                    </div>
                `;
                console.error('Erreur:', error);
            });
        });
    }

    // Fonction pour suggérer des alternatives
    function suggestAlternative() {
        // Cette fonction pourrait faire un appel AJAX pour obtenir des suggestions alternatives
        // Pour l'instant, affichons juste un message
        const resultDiv = document.getElementById('availability-result');
        const currentHTML = resultDiv.innerHTML;
        
        resultDiv.innerHTML = currentHTML + `
            <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-6 shadow-sm">
                <h4 class="font-medium text-blue-800 mb-3">Alternatives disponibles</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button class="p-4 border border-blue-200 rounded-lg bg-white hover:bg-blue-50 transition text-left">
                        <div class="font-medium">Aujourd'hui à 20:30</div>
                        <div class="text-sm text-gray-500">Disponible pour votre groupe</div>
                    </button>
                    <button class="p-4 border border-blue-200 rounded-lg bg-white hover:bg-blue-50 transition text-left">
                        <div class="font-medium">Demain à 19:00</div>
                        <div class="text-sm text-gray-500">Disponible pour votre groupe</div>
                    </button>
                </div>
            </div>
        `;
    }
</script>
@endsection