@extends('layouts.app')

@section('content')

    <h1 class="text-3xl mb-6">Profil</h1>

    <div class="bg-gray-800 p-6 rounded-xl w-96">

        <p><strong>Nom :</strong> {{ $user->name }}</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>

    </div>

@endsection
