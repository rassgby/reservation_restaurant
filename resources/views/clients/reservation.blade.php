@extends('layouts.client')

@section('title', 'Réserver une Table')

@section('styles')
<style>
    /* Variables CSS pour faciliter la maintenance et la cohérence */
    :root {
        --color-gold: #D4AF37;
        --color-gold-dark: #B8860B;
        --color-white: #ffffff;
        --color-black: #000000;
        --font-serif: serif;
    }

    .bg-restaurant {
        background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/api/placeholder/1200/600');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    
    .reservation-form {
        backdrop-filter: blur(10px);
        background-color: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
    }
    
    .btn-gold {
        background-color: var(--color-gold);
        color: var(--color-white);
        transition: all 0.3s ease;
    }
    
    .btn-gold:hover {
        background-color: var(--color-gold-dark);
        transform: translateY(-2px);
    }
    
    .form-input:focus {
        border-color: var(--color-gold);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        outline: none;
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
        background-color: var(--color-gold);
        bottom: -10px;
        left: 0;
    }
    
    .reservation-step {
        position: relative;
        padding-left: 40px;
    }
    
    .step-number {
        position: absolute;
        left: 0;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: var(--color-gold);
        color: var(--color-white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .text-restaurant-gold {
        color: var(--color-gold);
    }
    
    .bg-restaurant-gold {
        background-color: var(--color-gold);
    }
    
    /* Animation subtile pour les cartes informatives */
    .info-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    /* Style pour les messages d'erreur de validation */
    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .reservation-step {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="bg-restaurant py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-5xl font-serif font-bold mb-4 text-white text-center">Réservez Votre Table</h1>
        <p class="text-white text-center text-lg mb-8">Une expérience gastronomique unique vous attend</p>
        
        <!-- Affichage des messages de succès/erreur -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 max-w-4xl mx-auto">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        
        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 max-w-4xl mx-auto">
            <p>{{ session('error') }}</p>
        </div>
        @endif
        
        <div class="reservation-form p-8 max-w-4xl mx-auto">
            <div class="mb-10">
                <div class="flex flex-col md:flex-row gap-8 mb-8">
                    <div class="reservation-step flex-1">
                        <div class="step-number">1</div>
                        <h3 class="font-serif font-bold text-lg mb-2">Choisissez votre date</h3>
                        <p class="text-gray-600">Sélectionnez le jour qui vous convient le mieux</p>
                    </div>
                    <div class="reservation-step flex-1">
                        <div class="step-number">2</div>
                        <h3 class="font-serif font-bold text-lg mb-2">Précisez les détails</h3>
                        <p class="text-gray-600">Indiquez l'heure et le nombre de convives</p>
                    </div>
                    <div class="reservation-step flex-1">
                        <div class="step-number">3</div>
                        <h3 class="font-serif font-bold text-lg mb-2">Confirmez</h3>
                        <p class="text-gray-600">Complétez votre réservation en un clic</p>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('client.reservation.store') }}" id="reservationForm" class="space-y-8">
                @csrf
                
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                    <h3 class="section-title font-serif text-xl font-bold mb-6">Date et Horaire</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-gray-700 font-medium mb-2">Date de réservation</label>
                            <div class="relative">
                                <input type="date" id="date" name="date"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg"
                                    min="{{ date('Y-m-d') }}" 
                                    value="{{ old('date', date('Y-m-d')) }}"
                                    required>
                            </div>
                            @error('date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="heure" class="block text-gray-700 font-medium mb-2">Heure d'arrivée</label>
                            <div class="relative">
                                <select id="heure" name="heure"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none"
                                    required>
                                    <option value="">Sélectionnez une heure</option>
                                    <optgroup label="Déjeuner">
                                        <option value="12:00" {{ old('heure') == '12:00' ? 'selected' : '' }}>12:00</option>
                                        <option value="12:30" {{ old('heure') == '12:30' ? 'selected' : '' }}>12:30</option>
                                        <option value="13:00" {{ old('heure') == '13:00' ? 'selected' : '' }}>13:00</option>
                                        <option value="13:30" {{ old('heure') == '13:30' ? 'selected' : '' }}>13:30</option>
                                        <option value="14:00" {{ old('heure') == '14:00' ? 'selected' : '' }}>14:00</option>
                                    </optgroup>
                                    <optgroup label="Dîner">
                                        <option value="19:00" {{ old('heure') == '19:00' ? 'selected' : '' }}>19:00</option>
                                        <option value="19:30" {{ old('heure') == '19:30' ? 'selected' : '' }}>19:30</option>
                                        <option value="20:00" {{ old('heure') == '20:00' ? 'selected' : '' }}>20:00</option>
                                        <option value="20:30" {{ old('heure') == '20:30' ? 'selected' : '' }}>20:30</option>
                                        <option value="21:00" {{ old('heure') == '21:00' ? 'selected' : '' }}>21:00</option>
                                        <option value="21:30" {{ old('heure') == '21:30' ? 'selected' : '' }}>21:30</option>
                                    </optgroup>
                                </select>
                                <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                    </svg>
                                </div>
                            </div>
                            @error('heure')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                    <h3 class="section-title font-serif text-xl font-bold mb-6">Détails de la réservation</h3>
                    <div class="mb-6">
                        <label for="nombre_personnes" class="block text-gray-700 font-medium mb-2">Nombre de convives</label>
                        <div class="relative">
                            <select id="nombre_personnes" name="nombre_personnes"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg appearance-none"
                                required>
                                <option value="">Sélectionnez le nombre de personnes</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('nombre_personnes') == $i ? 'selected' : '' }}>
                                        {{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}
                                    </option>
                                @endfor
                                <option value="plus_de_10" {{ old('nombre_personnes') == 'plus_de_10' ? 'selected' : '' }}>
                                    Plus de 10 personnes (nous contacter)
                                </option>
                            </select>
                            <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                                </svg>
                            </div>
                        </div>
                        @error('nombre_personnes')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="special_requests" class="block text-gray-700 font-medium mb-2">
                            Demandes spéciales <span class="text-gray-400 text-sm">(optionnel)</span>
                        </label>
                        <textarea id="special_requests" name="special_requests" rows="3"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg"
                            placeholder="Allergies, occasion spéciale, préférences de placement...">{{ old('special_requests') }}</textarea>
                        @error('special_requests')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-center mt-8">
                    <button type="submit"
                        class="px-10 py-4 bg-restaurant-gold text-white rounded-lg font-bold btn-gold hover:shadow-lg flex items-center"
                        id="submitBtn">
                        <span>Confirmer ma réservation</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" class="ml-2">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                        </svg>
                    </button>
                </div>
            </form>
            
            <div class="mt-10 text-center">
                <p class="text-gray-500">Vous pouvez également nous contacter par téléphone au <span class="font-semibold">77 777 77 77</span></p>
            </div>
        </div>
    </div>
</div>

<!-- Section informative -->
<div class="container mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center p-6 info-card bg-white rounded-lg shadow-sm">
            <div class="mb-4 text-restaurant-gold">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16" class="mx-auto">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                </svg>
            </div>
            <h3 class="font-serif font-bold text-xl mb-2">Confirmation immédiate</h3>
            <p class="text-gray-600">Recevez une confirmation par email instantanément après votre réservation</p>
        </div>
        <div class="text-center p-6 info-card bg-white rounded-lg shadow-sm">
            <div class="mb-4 text-restaurant-gold">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16" class="mx-auto">
                    <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM1.5 8a6.5 6.5 0 1 0 13 0 6.5 6.5 0 0 0-13 0z"/>
                </svg>
            </div>
            <h3 class="font-serif font-bold text-xl mb-2">Annulation flexible</h3>
            <p class="text-gray-600">Possibilité d'annuler ou modifier jusqu'à 24h avant votre venue</p>
        </div>
        <div class="text-center p-6 info-card bg-white rounded-lg shadow-sm">
            <div class="mb-4 text-restaurant-gold">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16" class="mx-auto">
                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                </svg>
            </div>
            <h3 class="font-serif font-bold text-xl mb-2">Menus saisonniers</h3>
            <p class="text-gray-600">Découvrez notre carte qui évolue au fil des saisons</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Définir la date minimum pour l'input date
        const dateInput = document.getElementById('date');
        if (dateInput) {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            
            // Vérifier si une date a déjà été définie (pour la persistence en cas d'erreur)
            if (!dateInput.value) {
                dateInput.value = formattedDate;
            }
            
            // S'assurer que la date minimum est correctement définie
            dateInput.setAttribute('min', formattedDate);
        }
        
        // Animation des sélecteurs au focus
        const formInputs = document.querySelectorAll('.form-input');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-restaurant-gold', 'ring-opacity-50');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-restaurant-gold', 'ring-opacity-50');
            });
        });
        
        // Validation côté client
        const form = document.getElementById('reservationForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Empêcher les double-soumissions
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return false;
                }
                
                // Vérifier que tous les champs requis sont remplis
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.parentElement.classList.add('border-red-500');
                        
                        // Créer un message d'erreur s'il n'existe pas déjà
                        const errorElement = field.parentElement.nextElementSibling;
                        if (!errorElement || !errorElement.classList.contains('error-message')) {
                            const errorMsg = document.createElement('p');
                            errorMsg.classList.add('error-message');
                            errorMsg.textContent = 'Ce champ est requis';
                            field.parentElement.parentElement.appendChild(errorMsg);
                        }
                    } else {
                        field.parentElement.classList.remove('border-red-500');
                        const errorElement = field.parentElement.nextElementSibling;
                        if (errorElement && errorElement.classList.contains('error-message')) {
                            errorElement.remove();
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
                
                // Éviter les doubles soumissions
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span>Traitement en cours...</span>';
                
                // Réactiver le bouton après 5 secondes (au cas où la soumission échoue)
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Confirmer ma réservation</span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16" class="ml-2"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/></svg>';
                }, 5000);
            });
        }
        
        // Pour l'option "Plus de 10 personnes"
        const nombrePersonnesSelect = document.getElementById('nombre_personnes');
        if (nombrePersonnesSelect) {
            nombrePersonnesSelect.addEventListener('change', function() {
                if (this.value === 'plus_de_10') {
                    alert('Pour les réservations de plus de 10 personnes, nous vous invitons à nous contacter directement par téléphone au 77 777 77 77.');
                }
            });
        }
    });
</script>
@endsection