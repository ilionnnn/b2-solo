@extends('layouts.app')

@section('content')

    <h1 class="text-3xl text-center mb-10">
        Respiration guidée
    </h1>

    <div class="flex flex-col items-center gap-6">

        <!-- CERCLE -->
        <div id="circle"
             class="w-64 h-64 border-8 border-gray-300 rounded-full flex items-center justify-center text-xl transition-all duration-[4000ms]">

            <span id="text">Prêt ?</span>

        </div>

        <!-- BOUTONS -->
        <div class="flex gap-4">

            <button onclick="startBreathing()"
                    class="bg-emerald-600 px-4 py-2 rounded">
                Commencer
            </button>

            <button onclick="pauseBreathing()"
                    class="bg-yellow-500 px-4 py-2 rounded">
                Pause
            </button>

            <button onclick="resetBreathing()"
                    class="bg-red-500 px-4 py-2 rounded">
                Reset
            </button>

        </div>

    </div>

    <script>
        let inhale = true;
        let interval = null;

        function startBreathing() {
            if (interval) return; // évite double lancement

            interval = setInterval(() => {
                document.getElementById('circle').style.transform =
                    inhale ? "scale(1.3)" : "scale(1)";

                document.getElementById('text').innerText =
                    inhale ? "Inspirer" : "Expirer";

                inhale = !inhale;
            }, 4000);
        }

        function pauseBreathing() {
            clearInterval(interval);
            interval = null;
        }

        function resetBreathing() {
            clearInterval(interval);
            interval = null;

            inhale = true;

            document.getElementById('circle').style.transform = "scale(1)";
            document.getElementById('text').innerText = "Prêt ?";
        }
    </script>

@endsection
