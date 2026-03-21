@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

    {{-- HERO --}}
    <div class="text-center py-16 px-4">
        <h1 class="font-lora text-5xl font-semibold text-white mb-3">
            CESIZen
        </h1>
        <h2 class="font-lora text-2xl font-normal text-emerald-400 mb-5">
            Votre espace bien-être
        </h2>
        <p class="text-slate-400 text-lg max-w-xl mx-auto leading-relaxed">
            Découvrez des exercices de respiration guidés et des ressources pour prendre soin de vous au quotidien.
        </p>
        <div class="flex gap-4 justify-center mt-8">
            <a href="{{ route('exercice_respiration.index') }}"
               class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold px-6 py-3 rounded-xl transition flex items-center gap-2">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M5 3l14 9-14 9V3z"/></svg>
                Commencer un exercice
            </a>
            <a href="{{ route('information.index') }}"
               class="text-slate-300 hover:text-white border border-slate-600 hover:border-slate-400 font-semibold px-6 py-3 rounded-xl transition">
                Nos informations
            </a>
        </div>
    </div>

    {{-- DERNIERS EXERCICES --}}
    <div class="mb-16">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-lora text-2xl font-semibold text-white">Exercices disponibles</h2>
            <a href="{{ route('exercice_respiration.index') }}"
               class="text-sm text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1">
                Voir tous
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($exercises->isEmpty())
            <div class="text-center py-10 text-slate-500 italic">Aucun exercice disponible pour le moment.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($exercises as $exercise)
                    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex flex-col gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">

                        <div class="flex items-center justify-between">
                        <span class="bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-3 py-1 rounded-full tracking-wider">
                            {{ $exercise->type }}
                        </span>
                            <span class="text-xs text-slate-500">{{ $exercise->nombre_cycles }} cycles</span>
                        </div>

                        <h3 class="font-lora text-lg font-semibold text-white leading-snug">
                            {{ $exercise->nom }}
                        </h3>

                        <p class="text-sm text-slate-400 leading-relaxed flex-1">
                            {{ Str::limit($exercise->description, 90) ?: 'Aucune description.' }}
                        </p>

                        <div class="bg-slate-900 rounded-xl px-3 py-3 flex items-center justify-center gap-3">
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-bold text-emerald-400 leading-none">{{ $exercise->duree_inspiration }}s</span>
                                <span class="text-[10px] uppercase tracking-wider text-emerald-600 mt-0.5">Inspi</span>
                            </div>
                            @if($exercise->duree_apnee > 0)
                                <span class="text-slate-600 pb-3">—</span>
                                <div class="flex flex-col items-center">
                                    <span class="text-xl font-bold text-amber-400 leading-none">{{ $exercise->duree_apnee }}s</span>
                                    <span class="text-[10px] uppercase tracking-wider text-amber-600 mt-0.5">Apnée</span>
                                </div>
                            @endif
                            <span class="text-slate-600 pb-3">—</span>
                            <div class="flex flex-col items-center">
                                <span class="text-xl font-bold text-blue-400 leading-none">{{ $exercise->duree_expiration }}s</span>
                                <span class="text-[10px] uppercase tracking-wider text-blue-600 mt-0.5">Expi</span>
                            </div>
                        </div>

                        <a href="{{ route('exercice_respiration.show', $exercise->id) }}"
                           class="flex items-center justify-center gap-2 bg-emerald-700 hover:bg-emerald-600 text-white font-semibold text-sm rounded-lg px-4 py-2.5 transition">
                            Commencer
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- INFORMATIONS --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-lora text-2xl font-semibold text-white">Informations</h2>
            <a href="{{ route('information.index') }}"
               class="text-sm text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1">
                Voir toutes
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

        @if($informations->isEmpty())
            <div class="text-center py-10 text-slate-500 italic">Aucune information disponible.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach($informations as $info)
                    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-5 flex flex-col gap-3 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">

                        <h3 class="font-lora text-lg font-semibold text-slate-100 leading-snug">
                            {{ $info->titre }}
                        </h3>

                        <p class="text-sm text-slate-400 leading-relaxed flex-1">
                            {{ Str::limit(strip_tags($info->contenu), 100) }}
                        </p>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-700">
                        <span class="text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($info->date_modification)->format('d/m/Y') }}
                        </span>
                            <a href="{{ route('information.show', $info->id) }}"
                               class="text-sm text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1">
                                Lire
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection

