@extends('layouts.app')

@section('title', $page->titre)

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white">{{ $page->titre }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('information.index') }}"
               class="text-sm text-slate-300 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition">
                Retour
            </a>
        </div>
    </div>

    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8">

        <div class="flex flex-wrap items-center gap-3 pb-4 mb-6 border-b border-slate-700">
        <span class="text-sm text-slate-400">
            Par <strong class="text-slate-300">{{ $page->user->name ?? 'Inconnu' }}</strong>
        </span>
            <span class="text-sm text-slate-500">
            Publié le {{ \Carbon\Carbon::parse($page->date_creation)->format('d/m/Y') }}
        </span>
            <span class="text-sm text-slate-500">
            Modifié le {{ \Carbon\Carbon::parse($page->date_modification)->format('d/m/Y à H:i') }}
        </span>
            @auth
                @if(auth()->user()->role === 1)
                    @if($page->statut === 'publié')
                        <span class="bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                        publié
                    </span>
                    @else
                        <span class="bg-amber-900/50 text-amber-300 border border-amber-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                        brouillon
                    </span>
                    @endif
                @endif
            @endauth
        </div>

        <div class="text-slate-300 leading-relaxed text-sm">
            {!! nl2br(e($page->contenu)) !!}
        </div>

        @auth
            @if(auth()->user()->role === 0)
                <div class="mt-8 pt-6 border-t border-slate-700">
                    <form action="{{ route('information.destroy', $page->id) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer cette page ?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-red-400 hover:text-red-300 border border-red-800 hover:border-red-600 rounded-lg px-4 py-2 transition">
                            Supprimer la page
                        </button>
                    </form>
                </div>
            @endif
        @endauth

    </div>

@endsection
