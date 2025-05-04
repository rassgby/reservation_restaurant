@extends('layouts.admin')

@section('title', 'Toutes les Disponibilités')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-3xl font-serif font-bold mb-6">Toutes les Disponibilités</h2>

    <form method="GET" class="flex items-center mb-6 space-x-3">
        <input type="date" name="date" value="{{ request('date') }}"
               class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
        <button type="submit"
                class="px-6 py-2 btn-gold rounded-full hover:text-white transition">
            Filtrer
        </button>
        <a href="{{ route('admin.disponibilites.index') }}"
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
                    <th class="py-3 px-4 text-left font-medium">Places restantes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($disponibilites as $d)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($d->date)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ $d->heure }}</td>
                        <td class="py-3 px-4">{{ $d->placesRestantes() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 px-4 text-center text-gray-500">
                            Aucune disponibilité trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($disponibilites->hasPages())
        <div class="mt-6">
            {{ $disponibilites->appends(request()->only('date'))->links() }}
        </div>
    @endif
</div>
@endsection
