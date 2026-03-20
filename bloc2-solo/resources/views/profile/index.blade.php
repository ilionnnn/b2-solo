@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-gray-900 ">Mon profil</h1>
        <a href="{{ route('profile.edit') }}"
           class="text-sm text-gray-900 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition">
            Modifier le profil
        </a>
    </div>

    {{-- INFOS USER --}}
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 mb-6 flex items-center gap-6">
        <div class="w-16 h-16 rounded-full bg-emerald-800 border-2 border-emerald-600 flex items-center justify-center text-2xl font-bold text-emerald-300">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <p class="text-xl font-semibold text-slate-100">{{ auth()->user()->name }}</p>
            <p class="text-sm text-slate-400">{{ auth()->user()->email }}</p>
            <span class="mt-1 inline-block text-xs font-bold px-2.5 py-0.5 rounded-full
            {{ auth()->user()->role === 1 ? 'bg-purple-900 text-purple-300 border border-purple-700' : 'bg-slate-700 text-slate-300 border border-slate-600' }}">
            {{ auth()->user()->role === 1 ? 'Administrateur' : 'Utilisateur' }}
        </span>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex flex-col items-center gap-1">
            {{--<span class="text-3xl font-bold text-blue-400">{{ $user->exercices->count() }}</span>--}}
            <span class="text-xs uppercase tracking-wider text-slate-500">Exercice(s) créé(s)</span>
        </div>
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex flex-col items-center gap-1">
            {{--<span class="text-3xl font-bold text-amber-400">{{ $user->informations->count() }}</span>--}}
            <span class="text-xs uppercase tracking-wider text-slate-500">Page(s) d'info créée(s)</span>
        </div>
        </div>
    </div>


@endsection
