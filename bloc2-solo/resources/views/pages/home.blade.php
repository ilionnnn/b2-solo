@extends('layouts.app')

@section('content')

    <h1 class="text-3xl text-center mb-10 font-light">
        Votre espace bien-être
    </h1>

    <div class="grid grid-cols-3 gap-6">

        @foreach($exercises as $exercise)

            <div class="bg-white text-black p-6 rounded-xl shadow-lg hover:scale-105 transition">

                <h2 class="text-lg font-bold mb-2">
                    {{ $exercise->name }}
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    Durée : {{ $exercise->duration ?? 'N/A' }} min
                </p>

                <a href="/exercises/{{ $exercise->id }}"
                   class="bg-emerald-600 text-white px-4 py-2 rounded">

                    Commencer

                </a>

            </div>

        @endforeach

    </div>

@endsection
