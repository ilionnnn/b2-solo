@extends('layouts.app')

@section('title', 'Informations')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white flex items-center gap-3">
            Informations
            @if($pages->count())
                <span class="bg-emerald-900 text-emerald-300 text-sm font-bold px-3 py-0.5 rounded-full">
                {{ $pages->count() }}
            </span>
            @endif
        </h1>
        @auth
            @if(auth()->user()->role === 1)
                <a href="{{ route('information.create') }}"
                   class="bg-emerald-700 hover:bg-emerald-600 text-white font-semibold text-sm px-4 py-2 rounded-lg transition flex items-center gap-2">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                    Nouvelle page
                </a>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="bg-emerald-900/40 border border-emerald-700 text-emerald-300 rounded-lg px-4 py-3 mb-6 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($pages->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-slate-500">
            <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24" class="mb-4 opacity-40">
                <path d="M9 13h6m-3-3v6m-7 4h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z"/>
            </svg>
            <p class="text-lg italic">Aucune information disponible</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($pages as $page)
                <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">

                    <div class="flex items-start justify-between gap-2">
                        <h2 class="font-lora text-lg font-semibold text-slate-100 leading-snug">
                            {{ $page->titre }}
                        </h2>
                        @auth
                            @if(auth()->user()->role === 1)
                                @if($page->statut === 'publié')
                                    <span class="shrink-0 bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                                    publié
                                </span>
                                @else
                                    <span class="shrink-0 bg-amber-900/50 text-amber-300 border border-amber-700 text-xs font-bold px-2.5 py-0.5 rounded-full">
                                    brouillon
                                </span>
                                @endif
                            @endif
                        @endauth
                    </div>

                    <p class="text-sm text-slate-400 leading-relaxed flex-1">
                        {{ Str::limit(strip_tags($page->contenu), 120) }}
                    </p>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-700 text-xs text-slate-500">
                        <span class="italic">Par {{ $page->user->name ?? 'Inconnu' }}</span>
                        <span>{{ \Carbon\Carbon::parse($page->date_modification)->format('d/m/Y') }}</span>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                        <a href="{{ route('information.show', $page->id) }}"
                           class="text-sm text-emerald-400 hover:text-emerald-300 border border-emerald-800 hover:border-emerald-600 rounded-lg px-4 py-1.5 transition">
                            Lire
                        </a>
                        @auth
                            @if(auth()->user()->role === 0 || auth()->user()->id === $page->user_id)
                                <div class="flex gap-2">
                                    <a href="{{ route('information.edit', $page->id) }}"
                                       class="text-xs text-slate-400 hover:text-slate-200 border border-slate-600 hover:border-slate-400 rounded-md px-3 py-1.5 transition">
                                        Modifier
                                    </a>
                                    <form action="{{ route('information.destroy', $page->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Supprimer cette page ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs text-red-400 hover:text-red-300 border border-red-800 hover:border-red-600 rounded-md px-3 py-1.5 transition">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>

                </div>
            @endforeach
        </div>
    @endif

@endsection
