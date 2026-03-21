@extends('layouts.app')

@section('title', 'Modifier l\'exercice')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white">Modifier l'exercice</h1>
        <a href="{{ route('exercice_respiration.index') }}"
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

    <form method="POST" action="{{ route('exercice_respiration.update', $exercice->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col gap-5">

                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Informations générales</p>

                <div class="flex flex-col gap-1.5">
                    <label for="nom" class="text-sm font-semibold text-slate-300">Nom de l'exercice</label>
                    <input type="text" id="nom" name="nom"
                           value="{{ old('nom', $exercice->nom) }}"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                    @error('nom') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="description" class="text-sm font-semibold text-slate-300">
                        Description <span class="text-slate-500 font-normal">(optionnel)</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none transition resize-none">{{ old('description', $exercice->description) }}</textarea>
                    @error('description') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="nombre_cycles" class="text-sm font-semibold text-slate-300">Nombre de cycles</label>
                    <input type="number" id="nombre_cycles" name="nombre_cycles"
                           value="{{ old('nombre_cycles', $exercice->nombre_cycles) }}" min="1"
                           oninput="updatePreview()"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 rounded-lg px-4 py-2.5 text-sm outline-none transition w-32">
                    @error('nombre_cycles') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="public" value="1"
                           {{ old('public', $exercice->public) ? 'checked' : '' }}
                           class="w-4 h-4 rounded accent-emerald-500">
                    <span class="text-sm text-slate-300">Visible par tous les utilisateurs</span>
                </label>

                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-semibold text-slate-300">Créé par</label>
                    <div class="bg-slate-900 border border-slate-700 text-slate-400 rounded-lg px-4 py-2.5 text-sm">
                        {{ $exercice->user->name ?? 'Inconnu' }}
                    </div>
                </div>

            </div>

            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col gap-5">

                <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Rythme respiratoire (en secondes)</p>

                <div class="grid grid-cols-3 gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="duree_inspiration" class="text-xs font-bold uppercase tracking-wider text-emerald-400">Inspiration</label>
                        <input type="number" id="duree_inspiration" name="duree_inspiration"
                               value="{{ old('duree_inspiration', $exercice->duree_inspiration) }}" min="1"
                               oninput="updatePreview()"
                               class="bg-slate-900 border border-emerald-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-emerald-300 rounded-lg px-3 py-2.5 text-sm outline-none transition text-center font-bold">
                        @error('duree_inspiration') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="duree_apnee" class="text-xs font-bold uppercase tracking-wider text-amber-400">Apnée</label>
                        <input type="number" id="duree_apnee" name="duree_apnee"
                               value="{{ old('duree_apnee', $exercice->duree_apnee) }}" min="0"
                               oninput="updatePreview()"
                               class="bg-slate-900 border border-amber-800 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-amber-300 rounded-lg px-3 py-2.5 text-sm outline-none transition text-center font-bold">
                        @error('duree_apnee') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label for="duree_expiration" class="text-xs font-bold uppercase tracking-wider text-blue-400">Expiration</label>
                        <input type="number" id="duree_expiration" name="duree_expiration"
                               value="{{ old('duree_expiration', $exercice->duree_expiration) }}" min="1"
                               oninput="updatePreview()"
                               class="bg-slate-900 border border-blue-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-blue-300 rounded-lg px-3 py-2.5 text-sm outline-none transition text-center font-bold">
                        @error('duree_expiration') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-slate-900 rounded-xl p-4 flex flex-col gap-3">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-500">Aperçu du rythme</p>
                    <div class="flex items-center justify-center gap-4">
                        <div class="flex flex-col items-center min-w-[52px]">
                            <span id="prev-inspire" class="text-2xl font-bold text-emerald-400 leading-none">{{ $exercice->duree_inspiration }}s</span>
                            <span class="text-[10px] uppercase tracking-wider text-emerald-600 mt-1">Inspiration</span>
                        </div>
                        <span id="sep-apnee" class="text-slate-600 text-lg pb-4" style="{{ $exercice->duree_apnee > 0 ? '' : 'display:none' }}">—</span>
                        <div id="bloc-apnee" class="flex flex-col items-center min-w-[52px]" style="{{ $exercice->duree_apnee > 0 ? '' : 'display:none' }}">
                            <span id="prev-apnee" class="text-2xl font-bold text-amber-400 leading-none">{{ $exercice->duree_apnee }}s</span>
                            <span class="text-[10px] uppercase tracking-wider text-amber-600 mt-1">Apnée</span>
                        </div>
                        <span class="text-slate-600 text-lg pb-4">—</span>
                        <div class="flex flex-col items-center min-w-[52px]">
                            <span id="prev-expire" class="text-2xl font-bold text-blue-400 leading-none">{{ $exercice->duree_expiration }}s</span>
                            <span class="text-[10px] uppercase tracking-wider text-blue-600 mt-1">Expiration</span>
                        </div>
                    </div>
                    <p id="preview-total" class="text-xs text-slate-500 text-center"></p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-lg px-6 py-2.5 transition">
                        Enregistrer
                    </button>
                    <a href="{{ route('exercice_respiration.index') }}"
                       class="flex items-center text-sm text-slate-400 hover:text-slate-200 border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2.5 transition">
                        Annuler
                    </a>
                </div>

            </div>

        </div>

    </form>

    <script>
        function updatePreview() {
            const insp   = parseInt(document.getElementById('duree_inspiration').value) || 0;
            const apnee  = parseInt(document.getElementById('duree_apnee').value)       || 0;
            const expi   = parseInt(document.getElementById('duree_expiration').value)  || 0;
            const cycles = parseInt(document.getElementById('nombre_cycles').value)     || 0;

            document.getElementById('prev-inspire').textContent = insp  + 's';
            document.getElementById('prev-apnee').textContent   = apnee + 's';
            document.getElementById('prev-expire').textContent  = expi  + 's';

            const showApnee = apnee > 0;
            document.getElementById('bloc-apnee').style.display = showApnee ? 'flex' : 'none';
            document.getElementById('sep-apnee').style.display  = showApnee ? 'block' : 'none';

            const total = (insp + apnee + expi) * cycles;
            const min   = Math.round(total / 60);
            document.getElementById('preview-total').textContent =
                `Durée totale : ${total}s (~${min} min) pour ${cycles} cycles`;
        }

        document.getElementById('nombre_cycles').addEventListener('input', updatePreview);
        updatePreview();
    </script>

@endsection
