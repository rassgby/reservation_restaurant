@extends('layouts.client')

@section('title', 'Vérifier les Disponibilités')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Vérifier les Disponibilités</h2>
    <form method="POST" action="{{ route('client.availability.check') }}" id="availability-form">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label for="check_date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" id="check_date" name="check_date"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                    min="{{ date('Y-m-d') }}" required>
            </div>
            <div>
                <label for="check_time" class="block text-gray-700 text-sm font-bold mb-2">Heure</label>
                <select id="check_time" name="check_time"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
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
            </div>
            <div>
                <label for="check_guests" class="block text-gray-700 text-sm font-bold mb-2">Nombre de personnes</label>
                <select id="check_guests" name="check_guests"
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                    required>
                    <option value="">Sélectionnez le nombre</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? 'personnes' : 'personne' }}</option>
                    @endfor
                    <option value="11">Plus de 10 personnes</option>
                </select>
            </div>
        </div>
        <button type="submit"
            class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
            Vérifier la disponibilité
        </button>
    </form>
    <div id="availability-result" class="mt-6"></div>
</div>
@endsection

@section('scripts')
<script>
    // Définir la date minimum pour l'input date
    const checkDateInput = document.getElementById('check_date');
    if (checkDateInput) {
        checkDateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
    }

    // Appel AJAX pour vérifier la disponibilité
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
