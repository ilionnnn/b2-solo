@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-6 text-center">

        CESIZen, Bienvenue dans votre espace bien être

    </h1>

    <div class="mb-8">

        <input
            type="text"
            placeholder="Recherche des ressources"
            class="w-full p-2 rounded text-black">

    </div>

    <h2 class="text-xl mb-4">
        Vos exercices
    </h2>

    <div class="grid grid-cols-3 gap-4">

        @foreach($exercises as $exercise)

            <div class="bg-white text-black p-4 rounded">

                <h3 class="font-bold">

                    {{ $exercise->name }}

                </h3>

                <p class="text-sm mb-2">

                    Progression

                </p>

                <a
                    href="/exercises/{{ $exercise->id }}"
                    class="bg-emerald-600 text-white px-3 py-1 rounded text-sm">

                    Voir l'exercice

                </a>

            </div>

        @endforeach

    </div>

@endsection
