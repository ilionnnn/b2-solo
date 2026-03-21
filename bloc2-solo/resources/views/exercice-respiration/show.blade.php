@extends('layouts.app')

@section('title', $exercice->nom)

@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="font-lora text-3xl font-semibold text-white">{{ $exercice->nom }}</h1>
        <div class="flex gap-2">
            @auth
                @if(auth()->user()->role === 1 || auth()->user()->id === $exercice->user_id)
                    <a href="{{ route('exercice_respiration.edit', $exercice->id) }}"
                       class="text-sm text-slate-300 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition">
                        Modifier
                    </a>
                @endif
            @endauth
            <a href="{{ route('exercice_respiration.index') }}"
               class="text-sm text-slate-300 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2 transition">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col gap-5">

            <div class="flex flex-wrap items-center gap-3 pb-4 border-b border-slate-700">
            <span class="bg-emerald-900 text-emerald-300 border border-emerald-700 text-xs font-bold px-3 py-1 rounded-full tracking-wider">
                {{ $exercice->type }}
            </span>
                <span class="text-sm text-slate-400">
                Par <strong class="text-slate-300">{{ $exercice->user->name ?? 'Inconnu' }}</strong>
            </span>
                <span class="text-sm text-slate-500">
                {{ \Carbon\Carbon::parse($exercice->date_creation)->format('d/m/Y') }}
            </span>
            </div>

            @if($exercice->description)
                <p class="text-sm text-slate-400 leading-relaxed">{{ $exercice->description }}</p>
            @endif

            <div class="bg-slate-900 rounded-xl px-4 py-4 flex items-center justify-center gap-4">
                <div class="flex flex-col items-center min-w-[56px]">
                    <span class="text-2xl font-bold text-emerald-400 leading-none">{{ $exercice->duree_inspiration }}s</span>
                    <span class="text-[10px] uppercase tracking-wider font-semibold text-emerald-600 mt-1">Inspiration</span>
                </div>
                @if($exercice->duree_apnee > 0)
                    <span class="text-slate-600 text-lg pb-4">—</span>
                    <div class="flex flex-col items-center min-w-[56px]">
                        <span class="text-2xl font-bold text-amber-400 leading-none">{{ $exercice->duree_apnee }}s</span>
                        <span class="text-[10px] uppercase tracking-wider font-semibold text-amber-600 mt-1">Apnée</span>
                    </div>
                @endif
                <span class="text-slate-600 text-lg pb-4">—</span>
                <div class="flex flex-col items-center min-w-[56px]">
                    <span class="text-2xl font-bold text-blue-400 leading-none">{{ $exercice->duree_expiration }}s</span>
                    <span class="text-[10px] uppercase tracking-wider font-semibold text-blue-600 mt-1">Expiration</span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="bg-slate-900 rounded-xl p-3 flex flex-col items-center gap-1">
                    <span class="text-[10px] uppercase tracking-wider text-slate-500">Cycles</span>
                    <span class="text-xl font-bold text-emerald-400">{{ $exercice->nombre_cycles }}</span>
                </div>
                <div class="bg-slate-900 rounded-xl p-3 flex flex-col items-center gap-1">
                    <span class="text-[10px] uppercase tracking-wider text-slate-500">Durée</span>
                    <span class="text-xl font-bold text-emerald-400">{{ $exercice->duree_totale }}s</span>
                </div>
                <div class="bg-slate-900 rounded-xl p-3 flex flex-col items-center gap-1">
                    <span class="text-[10px] uppercase tracking-wider text-slate-500">Environ</span>
                    <span class="text-xl font-bold text-emerald-400">{{ round($exercice->duree_totale / 60) }} min</span>
                </div>
            </div>

            @auth
                @if(auth()->user()->role === 1)
                    <div class="pt-4 border-t border-slate-700">
                        <form action="{{ route('exercice_respiration.destroy', $exercice->id) }}"
                              method="POST"
                              onsubmit="return confirm('Supprimer cet exercice ?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm text-red-400 hover:text-red-300 border border-red-800 hover:border-red-600 rounded-lg px-4 py-2 transition">
                                Supprimer l'exercice
                            </button>
                        </form>
                    </div>
                @endif
            @endauth

        </div>

        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 flex flex-col items-center gap-6">

            <p class="font-lora text-lg font-semibold text-slate-200">Suivez le rythme</p>

            <div class="relative w-40 h-40">
                <svg class="absolute top-0 left-0 w-full h-full -rotate-90" viewBox="0 0 160 160">
                    <circle cx="80" cy="80" r="66" fill="none" stroke="#1e293b" stroke-width="6"/>
                    <circle id="progress-circle" cx="80" cy="80" r="66" fill="none"
                            stroke="#34d399" stroke-width="6" stroke-linecap="round"
                            stroke-dasharray="415" stroke-dashoffset="415"
                            style="transition: stroke-dashoffset 0.1s linear"/>
                </svg>
                <div id="breath-circle"
                     class="absolute inset-0 rounded-full flex flex-col items-center justify-center gap-1 transition-all duration-300"
                     style="background:#1e293b">
                    <span id="phase-label" class="font-lora text-base font-semibold text-emerald-300">Prêt ?</span>
                    <span id="timer-label" class="text-sm text-slate-400"></span>
                </div>
            </div>

            <p id="cycle-count" class="text-sm text-slate-500 min-h-5"></p>

            <div class="flex gap-3">
                <button onclick="resetBreathing()"
                        class="flex items-center gap-2 text-sm text-slate-400 hover:text-slate-200 border border-slate-600 hover:border-slate-400 rounded-lg px-4 py-2.5 transition">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M1 4v6h6M23 20v-6h-6"/><path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4-4.64 4.36A9 9 0 0 1 3.51 15"/>
                    </svg>
                    Reset
                </button>
                <button id="start-btn" onclick="toggleBreathing()"
                        class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm rounded-lg px-6 py-2.5 transition">
                    <svg id="btn-icon" width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 3l14 9-14 9V3z"/>
                    </svg>
                    <span id="btn-label">Commencer</span>
                </button>
            </div>

        </div>

    </div>

    <script>
        const PHASES = [
            { name: 'Inspirer', dur: {{ $exercice->duree_inspiration }}, scale: 1.1, bg: '#064e3b', color: '#6ee7b7' },
                @if($exercice->duree_apnee > 0)
            { name: 'Retenir',  dur: {{ $exercice->duree_apnee }},       scale: 1.1, bg: '#451a03', color: '#fbbf24' },
                @endif
            { name: 'Expirer',  dur: {{ $exercice->duree_expiration }},  scale: 1,   bg: '#1e3a5f', color: '#93c5fd' },
        ];
        const MAX_CYCLES = {{ $exercice->nombre_cycles }};
        const DASHARRAY  = 415;

        let running = false, raf = null, phaseIdx = 0, phaseStart = null, cycles = 0;

        function toggleBreathing() {
            if (running) { pauseBreathing(); return; }
            running = true;
            document.getElementById('btn-label').textContent = 'Pause';
            document.getElementById('btn-icon').innerHTML = '<rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/>';
            phaseStart = performance.now();
            loop(performance.now());
        }

        function pauseBreathing() {
            running = false;
            cancelAnimationFrame(raf);
            document.getElementById('btn-label').textContent = 'Reprendre';
            document.getElementById('btn-icon').innerHTML = '<path d="M5 3l14 9-14 9V3z"/>';
        }

        function resetBreathing() {
            running = false;
            cancelAnimationFrame(raf);
            phaseIdx = 0; cycles = 0; phaseStart = null;
            document.getElementById('btn-label').textContent = 'Commencer';
            document.getElementById('btn-icon').innerHTML = '<path d="M5 3l14 9-14 9V3z"/>';
            document.getElementById('phase-label').textContent = 'Prêt ?';
            document.getElementById('phase-label').style.color = '#6ee7b7';
            document.getElementById('timer-label').textContent = '';
            document.getElementById('breath-circle').style.transform = 'scale(1)';
            document.getElementById('breath-circle').style.background = '#1e293b';
            document.getElementById('progress-circle').style.strokeDashoffset = DASHARRAY;
            document.getElementById('cycle-count').textContent = '';
        }

        function loop(now) {
            if (!running) return;
            const phase    = PHASES[phaseIdx];
            const elapsed  = (now - phaseStart) / 1000;
            const progress = Math.min(elapsed / phase.dur, 1);
            const remaining = Math.ceil(phase.dur - elapsed);

            document.getElementById('phase-label').textContent  = phase.name;
            document.getElementById('phase-label').style.color  = phase.color;
            document.getElementById('timer-label').textContent  = remaining + 's';
            document.getElementById('breath-circle').style.transform  = `scale(${phase.scale})`;
            document.getElementById('breath-circle').style.background = phase.bg;
            document.getElementById('progress-circle').style.strokeDashoffset = DASHARRAY * (1 - progress);

            if (progress >= 1) {
                phaseIdx++;
                if (phaseIdx >= PHASES.length) {
                    phaseIdx = 0; cycles++;
                    if (cycles >= MAX_CYCLES) {
                        resetBreathing();
                        document.getElementById('cycle-count').textContent = 'Exercice terminé !';
                        return;
                    }
                    document.getElementById('cycle-count').textContent = `Cycle ${cycles} / ${MAX_CYCLES}`;
                }
                phaseStart = now;
            }
            raf = requestAnimationFrame(loop);
        }
    </script>

@endsection
