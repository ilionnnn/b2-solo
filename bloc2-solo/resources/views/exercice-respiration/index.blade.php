@extends('layouts.app')

@section('title', 'Exercices de respiration')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white flex items-center gap-3">
            Exercices de respiration
            @if($exercices->count())
                <span class="bg-emerald-900 text-emerald-300 text-sm font-bold px-3 py-0.5 rounded-full">
                {{ $exercices->count() }}
            </span>
            @endif
        </h1>
        @auth
            <a href="{{ route('exercice_respiration.create') }}"
               class="bg-emerald-700 hover:bg-emerald-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                Nouvel exercice
            </a>
        @endauth
    </div>

    @if(session('success'))
        <div class="bg-emerald-900/40 border border-emerald-700 text-emerald-300 rounded-lg px-4 py-3 mb-6 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($exercices->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
            <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" class="mb-4 opacity-40">
                <circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/>
            </svg>
            <p class="text-lg italic">Aucun exercice disponible</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($exercices as $exercice)
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">

                    <div class="flex items-center justify-between">
                    <span class="bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-3 py-1 rounded-full tracking-wider">
                        {{ $exercice->type }}
                    </span>
                        @auth
                            @if(auth()->user()->role === 0 || auth()->user()->id === $exercice->user_id)
                                <div class="flex gap-2">
                                    <a href="{{ route('exercice_respiration.edit', $exercice->id) }}"
                                       class="text-xs text-slate-400 hover:text-slate-200 border border-slate-600 hover:border-slate-400 rounded-md px-2.5 py-1 transition">
                                        Modifier
                                    </a>
                                    <form action="{{ route('exercice_respiration.destroy', $exercice->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer cet exercice ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs text-red-400 hover:text-red-300 border border-red-800 hover:border-red-600 rounded-md px-2.5 py-1 transition">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                    <h2 class="font-lora text-lg font-semibold text-slate-100 leading-snug">
                        {{ $exercice->nom }}
                    </h2>

                    <p class="text-sm text-slate-400 leading-relaxed flex-1">
                        {{ Str::limit($exercice->description, 110) ?: 'Aucune description.' }}
                    </p>

                    <div class="bg-slate-900 rounded-xl px-4 py-3 flex items-center justify-center gap-3">
                        <div class="flex flex-col items-center min-w-[48px]">
                            <span class="text-2xl font-bold text-emerald-400 leading-none">{{ $exercice->duree_inspiration }}s</span>
                            <span class="text-[10px] uppercase tracking-wider font-semibold text-emerald-600 mt-0.5">Inspiration</span>
                        </div>
                        @if($exercice->duree_apnee > 0)
                            <span class="text-slate-600 text-lg pb-3">—</span>
                            <div class="flex flex-col items-center min-w-[48px]">
                                <span class="text-2xl font-bold text-amber-400 leading-none">{{ $exercice->duree_apnee }}s</span>
                                <span class="text-[10px] uppercase tracking-wider font-semibold text-amber-600 mt-0.5">Apnée</span>
                            </div>
                        @endif
                        <span class="text-slate-600 text-lg pb-3">—</span>
                        <div class="flex flex-col items-center min-w-[48px]">
                            <span class="text-2xl font-bold text-blue-400 leading-none">{{ $exercice->duree_expiration }}s</span>
                            <span class="text-[10px] uppercase tracking-wider font-semibold text-blue-600 mt-0.5">Expiration</span>
                        </div>
                    </div>

                    <div class="flex gap-4 text-xs text-slate-500">
                    <span class="flex items-center gap-1">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        {{ $exercice->duree_totale }}s
                    </span>
                        <span class="flex items-center gap-1">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 3a2.85 2.85 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>
                        {{ $exercice->nombre_cycles }} cycles
                    </span>
                    </div>

                    <a href="{{ route('exercice_respiration.show', $exercice->id) }}"
                       class="mt-auto flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-600 text-white font-semibold text-sm rounded-lg px-4 py-2.5 transition">
                        Commencer l'exercice
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>

                </div>
            @endforeach
        </div>
    @endif

@endsection
