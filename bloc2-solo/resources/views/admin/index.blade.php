
@extends('layouts.app')

@section('title', 'Administration')

@section('content')

    {{-- ── HEADER ── --}}
    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white">Administration</h1>
        <span class="text-xs font-bold uppercase tracking-widest text-emerald-400 border border-emerald-700 bg-emerald-900/30 px-3 py-1.5 rounded-full">
            Accès admin
        </span>
    </div>

    {{-- ── ALERTS ── --}}
    @if(session('success'))
        <div class="bg-emerald-900/40 border border-emerald-700 text-emerald-300 rounded-lg px-4 py-3 mb-6 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    {{-- ── STATS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex items-center gap-4">
            <div class="bg-emerald-900/50 border border-emerald-700 rounded-xl p-3">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" class="text-emerald-400" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $total_users }}</p>
                <p class="text-xs text-slate-400 uppercase tracking-wider mt-0.5">Utilisateurs</p>
            </div>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex items-center gap-4">
            <div class="bg-blue-900/50 border border-blue-700 rounded-xl p-3">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" class="text-blue-400" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $total_exercices }}</p>
                <p class="text-xs text-slate-400 uppercase tracking-wider mt-0.5">Exercices</p>
            </div>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex items-center gap-4">
            <div class="bg-amber-900/50 border border-amber-700 rounded-xl p-3">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" class="text-amber-400" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-white">{{ $total_admins }}</p>
                <p class="text-xs text-slate-400 uppercase tracking-wider mt-0.5">Admins</p>
            </div>
        </div>

    </div>

    {{-- ── UTILISATEURS ── --}}
    <div class="mb-10">

        <h2 class="font-lora text-xl font-semibold text-white mb-4 flex items-center gap-2">
            Utilisateurs
            <span class="bg-slate-700 text-slate-300 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $total_users }}</span>
        </h2>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden">
            @if($users->isEmpty())
                <p class="text-slate-500 italic text-sm text-center py-10">Aucun utilisateur.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest">
                            <th class="text-left px-5 py-3 font-semibold">ID</th>
                            <th class="text-left px-5 py-3 font-semibold">Nom</th>
                            <th class="text-left px-5 py-3 font-semibold">Email</th>
                            <th class="text-left px-5 py-3 font-semibold">Rôle</th>
                            <th class="text-right px-5 py-3 font-semibold">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="border-t border-slate-700 hover:bg-slate-700/30 transition">
                                <td class="px-5 py-3.5">
                                    <span class="bg-slate-700 text-slate-300 text-xs font-bold px-2 py-0.5 rounded">#{{ $user->id }}</span>
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-slate-200">{{ $user->name }}</td>
                                <td class="px-5 py-3.5 text-slate-400">{{ $user->email }}</td>
                                <td class="px-5 py-3.5">
                                    @if($user->role === 0)
                                        <span class="bg-amber-900/50 border border-amber-700 text-amber-300 text-xs font-bold px-2.5 py-1 rounded-full">Admin</span>
                                    @else
                                        <span class="bg-slate-700 text-slate-400 text-xs font-bold px-2.5 py-1 rounded-full">Utilisateur</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Supprimer {{ $user->name }} ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs text-red-400 hover:text-red-300 border border-red-800 hover:border-red-600 rounded-md px-2.5 py-1 transition">
                                                Supprimer
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-600 italic">Vous</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- ── EXERCICES ── --}}
    <div>

        <h2 class="font-lora text-xl font-semibold text-white mb-4 flex items-center gap-2">
            Exercices de respiration
            <span class="bg-slate-700 text-slate-300 text-xs font-bold px-2.5 py-0.5 rounded-full">{{ $total_exercices }}</span>
        </h2>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden">
            @if($exercices->isEmpty())
                <p class="text-slate-500 italic text-sm text-center py-10">Aucun exercice.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                        <tr class="bg-slate-700/50 text-slate-400 text-xs uppercase tracking-widest">
                            <th class="text-left px-5 py-3 font-semibold">ID</th>
                            <th class="text-left px-5 py-3 font-semibold">Nom</th>
                            <th class="text-left px-5 py-3 font-semibold">Créateur</th>
                            <th class="text-left px-5 py-3 font-semibold">Rythme</th>
                            <th class="text-left px-5 py-3 font-semibold">Cycles</th>
                            <th class="text-left px-5 py-3 font-semibold">Durée</th>
                            <th class="text-left px-5 py-3 font-semibold">Visibilité</th>
                            <th class="text-right px-5 py-3 font-semibold">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($exercices as $exercice)
                            <tr class="border-t border-slate-700 hover:bg-slate-700/30 transition">
                                <td class="px-5 py-3.5">
                                    <span class="bg-slate-700 text-slate-300 text-xs font-bold px-2 py-0.5 rounded">#{{ $exercice->id }}</span>
                                </td>
                                <td class="px-5 py-3.5 font-semibold text-slate-200">{{ $exercice->nom }}</td>
                                <td class="px-5 py-3.5 text-slate-400">{{ $exercice->user->name ?? '—' }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="text-emerald-400 font-bold">{{ $exercice->duree_inspiration }}s</span>
                                    @if($exercice->duree_apnee > 0)
                                        <span class="text-slate-600 mx-0.5">—</span>
                                        <span class="text-amber-400 font-bold">{{ $exercice->duree_apnee }}s</span>
                                    @endif
                                    <span class="text-slate-600 mx-0.5">—</span>
                                    <span class="text-blue-400 font-bold">{{ $exercice->duree_expiration }}s</span>
                                </td>
                                <td class="px-5 py-3.5 text-slate-300">{{ $exercice->nombre_cycles }}</td>
                                <td class="px-5 py-3.5 text-slate-400">{{ $exercice->duree_totale }}s</td>
                                <td class="px-5 py-3.5">
                                    @if($exercice->public)
                                        <span class="bg-emerald-900/50 border border-emerald-700 text-emerald-300 text-xs font-bold px-2.5 py-1 rounded-full">Public</span>
                                    @else
                                        <span class="bg-slate-700 text-slate-400 text-xs font-bold px-2.5 py-1 rounded-full">Privé</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('exercice_respiration.edit', $exercice->id) }}"
                                           class="text-xs text-slate-400 hover:text-slate-200 border border-slate-600 hover:border-slate-400 rounded-md px-2.5 py-1 transition">
                                            Modifier
                                        </a>
                                        <form action="{{ route('admin.exercices.destroy', $exercice->id) }}" method="POST"
                                              onsubmit="return confirm('Supprimer « {{ $exercice->nom }} » ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-xs text-red-400 hover:text-red-300 border border-red-800 hover:border-red-600 rounded-md px-2.5 py-1 transition">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
