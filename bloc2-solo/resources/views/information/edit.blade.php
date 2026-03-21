@extends('layouts.app')

@section('title', 'Modifier la page')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white">Modifier la page</h1>
        <a href="{{ route('information.index') }}"
           class="text-sm text-slate-300 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition">
            Retour
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-lg px-4 py-3 mb-6 text-sm">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('information.update', $page->id) }}">
        @csrf
        @method('PUT')

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col gap-5 max-w-2xl">

            <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Contenu de la page</p>

            <div class="flex flex-col gap-1.5">
                <label for="titre" class="text-sm font-semibold text-slate-300">Titre</label>
                <input type="text" id="titre" name="titre"
                       value="{{ old('titre', $page->titre) }}"
                       placeholder="Ex : Mentions légales"
                       class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                @error('titre')
                <p class="text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="contenu" class="text-sm font-semibold text-slate-300">Contenu</label>
                <textarea id="contenu" name="contenu" rows="10"
                          class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition resize-y">{{ old('contenu', $page->contenu) }}</textarea>
                @error('contenu')
                <p class="text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="statut" class="text-sm font-semibold text-slate-300">Statut</label>
                <select id="statut" name="statut"
                        class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                    <option value="brouillon" {{ old('statut', $page->statut) === 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="publié"    {{ old('statut', $page->statut) === 'publié'    ? 'selected' : '' }}>Publié</option>
                </select>
                @error('statut')
                <p class="text-red-400 text-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-300">Créé par</label>
                    <div class="bg-slate-900 border border-slate-700 text-slate-400 rounded-lg px-4 py-2.5 text-sm">
                        {{ $page->user->name ?? 'Inconnu' }}
                    </div>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-300">Dernière modification</label>
                    <div class="bg-slate-900 border border-slate-700 text-slate-400 rounded-lg px-4 py-2.5 text-sm">
                        {{ \Carbon\Carbon::parse($page->date_modification)->format('d/m/Y à H:i') }}
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2 border-t border-slate-700">
                <button type="submit"
                        class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-lg px-6 py-2.5 transition">
                    Enregistrer
                </button>
                <a href="{{ route('information.index') }}"
                   class="flex items-center text-sm text-slate-400 hover:text-slate-200 border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2.5 transition">
                    Annuler
                </a>
            </div>

        </div>

    </form>

@endsection
