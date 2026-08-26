@extends('layouts.app')

@section('title', 'Espace modération')

@section('content')
<div class="max-w-4xl mx-auto py-10 space-y-6">
    <h1 class="font-lora text-3xl font-semibold text-white">Espace modération</h1>
    <p class="text-slate-400">Bienvenue {{ auth()->user()->name }}. Cet espace est réservé aux modérateurs.</p>

    <div class="grid gap-4 sm:grid-cols-2">
        <a href="{{ route('information.index') }}"
           class="bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-emerald-500 transition">
            <h2 class="text-lg font-semibold text-white">Contenus d'information</h2>
            <p class="text-slate-400 text-sm mt-1">Consulter et vérifier les contenus publiés.</p>
        </a>
        <a href="{{ route('exercice_respiration.index') }}"
           class="bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-emerald-500 transition">
            <h2 class="text-lg font-semibold text-white">Exercices de respiration</h2>
            <p class="text-slate-400 text-sm mt-1">Surveiller la cohérence des exercices proposés.</p>
        </a>
    </div>
</div>
@endsection
