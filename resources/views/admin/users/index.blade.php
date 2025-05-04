@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-serif font-bold">Utilisateurs</h2>
        <a href="{{ route('admin.users.create') }}"
           class="px-6 py-2 btn-gold rounded-full">
            + Nouvel utilisateur
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left font-medium">Nom</th>
                    <th class="py-3 px-4 text-left font-medium">Email</th>
                    <th class="py-3 px-4 text-left font-medium">Type</th>
                    <th class="py-3 px-4 text-left font-medium">Actif</th>
                    <th class="py-3 px-4 text-left font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $u)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $u->prenom }} {{ $u->nom }}</td>
                    <td class="py-3 px-4">{{ $u->email }}</td>
                    <td class="py-3 px-4">{{ ucfirst($u->type) }}</td>
                    <td class="py-3 px-4">
                        @if($u->is_active)
                            <span class="text-green-600">Oui</span>
                        @else
                            <span class="text-red-600">Non</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 space-x-2">
                        <a href="{{ route('admin.users.edit', $u) }}"
                           class="text-blue-600 hover:underline">Modifier</a>
                        <form action="{{ route('admin.users.destroy', $u) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Supprimer cet utilisateur ?')"
                                    class="text-red-600 hover:underline">Supprimer</button>
                        </form>
                        <form action="{{ route('admin.users.toggle', $u) }}" method="POST" class="inline">
                            @csrf
                            <button class="text-gray-600 hover:underline">
                                {{ $u->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
