@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-6">
        Mon profil
    </h1>

    <div class="bg-gray-800 p-6 rounded w-96">

        <p>
            Nom : {{ auth()->user()->name }}
        </p>

        <p>
            Email : {{ auth()->user()->email }}
        </p>

    </div>

@endsection
