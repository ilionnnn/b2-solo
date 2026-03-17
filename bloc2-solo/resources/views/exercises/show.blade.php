@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-6">
        {{ $exercise->name }}
    </h1>

    <p class="mb-4">
        Durée : {{ $exercise->duration }}
    </p>

    <p class="mb-6">
        {{ $exercise->description }}
    </p>

    <a href="/exercises" class="text-emerald-400">
        Retour
    </a>

@endsection
