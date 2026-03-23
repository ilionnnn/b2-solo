@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white">Mon profil</h1>
        <a href="{{ route('profile.edit') }}"
           class="text-sm text-slate-300 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition">
            Modifier le profil
        </a>
    </div>

    {{-- INFOS USER --}}
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 mb-6 flex items-center gap-6">
        <div class="w-16 h-16 rounded-full bg-emerald-900 border-2 border-emerald-600 flex items-center justify-center text-2xl font-bold text-emerald-300 shrink-0">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <div class="flex flex-col gap-1">
            <p class="text-xl font-semibold text-slate-100">{{ $user->name }}</p>
            <p class="text-sm text-slate-400">{{ $user->email }}</p>
            <div class="mt-1">
                @if($user->role === 1)
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-purple-900 text-purple-300 border border-purple-700">
                    Administrateur
                </span>
                @else
                    <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-slate-700 text-slate-300 border border-slate-600">
                    Utilisateur
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex flex-col items-center gap-1">
            <span class="text-3xl font-bold text-blue-400">{{ $user->exercices()->count() }}</span>
            <span class="text-xs uppercase tracking-wider text-slate-500">Exercice(s) créé(s)</span>
        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex flex-col items-center gap-1">
            <span class="text-3xl font-bold text-amber-400">{{ $user->informations()->count() }}</span>
            <span class="text-xs uppercase tracking-wider text-slate-500">Page(s) d'info créée(s)</span>
        </div>

    </div>

    {{-- EXERCICES --}}
    @if($user->exercices->count())
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-lora text-xl font-semibold text-white">Mes exercices</h2>
                <a href="{{ route('exercice_respiration.index') }}"
                   class="text-sm text-emerald-400 hover:text-emerald-300 flex items-center gap-1 transition">
                    Voir tous
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-slate-700">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-wider text-slate-500">Nom</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-wider text-slate-500">Type</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-wider text-slate-500">Créé le</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->exercices->take(5) as $exercice)
                        <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                            <td class="px-5 py-3 text-slate-200 font-medium">{{ $exercice->nom }}</td>
                            <td class="px-5 py-3">
                                <span class="bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $exercice->type }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ \Carbon\Carbon::parse($exercice->date_creation)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('exercice_respiration.show', $exercice->id) }}"
                                   class="text-emerald-400 hover:text-emerald-300 transition text-xs flex items-center gap-1 justify-end">
                                    Voir
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- INFORMATIONS --}}
    @if($user->informations->count())
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-lora text-xl font-semibold text-white">Mes pages d'information</h2>
                <a href="{{ route('information.index') }}"
                   class="text-sm text-emerald-400 hover:text-emerald-300 flex items-center gap-1 transition">
                    Voir toutes
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="border-b border-slate-700">
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-wider text-slate-500">Titre</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-wider text-slate-500">Statut</th>
                        <th class="text-left px-5 py-3 text-xs uppercase tracking-wider text-slate-500">Modifiée le</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($user->informations->take(5) as $info)
                        <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition">
                            <td class="px-5 py-3 text-slate-200 font-medium">{{ $info->titre }}</td>
                            <td class="px-5 py-3">
                                @if($info->statut === 'publié')
                                    <span class="bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                        publié
                                    </span>
                                @else
                                    <span class="bg-amber-900/50 text-amber-300 border border-amber-700 text-xs font-bold px-2 py-0.5 rounded-full">
                                        brouillon
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-slate-500">
                                {{ \Carbon\Carbon::parse($info->date_modification)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('information.show', $info->id_page) }}"
                                   class="text-emerald-400 hover:text-emerald-300 transition text-xs flex items-center gap-1 justify-end">
                                    Voir
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
