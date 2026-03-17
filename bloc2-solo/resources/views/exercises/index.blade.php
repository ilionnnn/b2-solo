@extends('layouts.app')

@section('content')

    <h1 class="text-3xl text-center mb-10">
        Respiration guidée
    </h1>

    <div class="flex justify-center">

        <div id="circle"
             class="w-64 h-64 border-8 border-gray-300 rounded-full flex items-center justify-center text-xl transition-all duration-[4000ms]">

            <span id="text">Inspirer</span>

        </div>

    </div>

    {{-- LISTE DES EXERCICES --}}
    <div class="mt-10 grid grid-cols-3 gap-6">

        @foreach($exercises as $exercise)

            <div class="bg-white text-black p-4 rounded-xl shadow">

                <h2 class="font-bold mb-2">
                    {{ $exercise->name }}
                </h2>

                <a href="/exercises/{{ $exercise->id }}"
                   class="bg-emerald-600 text-white px-3 py-1 rounded">

                    Voir

                </a>

            </div>

        @endforeach

    </div>

    <script>
        let inhale = true;
        setInterval(() => {
            document.getElementById('circle').style.transform = inhale ? "scale(1.3)" : "scale(1)";
            document.getElementById('text').innerText = inhale ? "Inspirer" : "Expirer";
            inhale = !inhale;
        }, 4000);
    </script>

@endsection
