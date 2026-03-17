@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-8">

        Dashboard Admin

    </h1>

    <div class="grid grid-cols-3 gap-6">

        <div class="bg-gray-800 p-6 rounded">

            Utilisateurs
            <br>

            {{ $users }}

        </div>

        <div class="bg-gray-800 p-6 rounded">

            Emotions enregistrées
            <br>

            {{ $emotions }}

        </div>

        <div class="bg-gray-800 p-6 rounded">

            Exercices faits
            <br>

            {{ $sessions }}

        </div>

    </div>

@endsection
