@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')

    <div class="flex justify-center items-center min-h-[70vh]">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 w-full max-w-md">

            <div class="text-center mb-8">
                <h1 class="font-lora text-3xl font-semibold text-white mb-2">Mot de passe oublié</h1>
                <p class="text-slate-400 text-sm">
                    Indiquez votre e-mail et nous vous enverrons un lien de réinitialisation.
                </p>
            </div>

            {{-- Status --}}
            @if(session('status'))
                <div class="bg-emerald-900/40 border border-emerald-700 text-emerald-300 rounded-lg px-4 py-3 mb-6 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-lg px-4 py-3 mb-6 text-sm">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-semibold text-slate-300">Adresse email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="votre@email.fr"
                           required autofocus autocomplete="email"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg px-4 py-2.5 text-sm transition">
                    Envoyer le lien de réinitialisation
                </button>

                <div class="text-center pt-2 border-t border-slate-700">
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-slate-200 text-sm transition">
                        ← Retour à la connexion
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
