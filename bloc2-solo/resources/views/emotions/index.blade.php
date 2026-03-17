@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-6">
        Mes émotions
    </h1>

    <a
        href="/emotions/create"
        class="bg-emerald-600 px-4 py-2 rounded">

        Ajouter

    </a>

    <div class="mt-6 space-y-4">

        @foreach($logs as $log)

            <div class="bg-gray-800 p-4 rounded">

                <h3>

                    {{ $log->emotion->name }}

                </h3>

                <p>

                    Intensité : {{ $log->intensity }}

                </p>

                <p>

                    {{ $log->note }}

                </p>

            </div>

        @endforeach

    </div>

@endsection
