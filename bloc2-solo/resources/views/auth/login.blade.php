@extends('layouts.app')

@section('content')

    <div class="flex justify-center items-center min-h-[70vh]">

        <div class="bg-gradient-to-b from-black to-gray-700 p-10 rounded-xl w-96">

            <h1 class="text-2xl mb-6 text-center">Connexion</h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <input type="email" name="email" placeholder="Email"
                       class="w-full mb-3 p-2 rounded text-black">

                <input type="password" name="password" placeholder="Password"
                       class="w-full mb-3 p-2 rounded text-black">

                <button class="bg-emerald-600 w-full py-2 rounded">
                    Login
                </button>

            </form>

        </div>

    </div>

@endsection
