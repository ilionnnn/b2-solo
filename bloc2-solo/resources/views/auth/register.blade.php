@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

    <div class="flex justify-center items-center min-h-[70vh]">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 w-full max-w-md">

            <div class="text-center mb-8">
                <h1 class="font-lora text-3xl font-semibold text-white mb-2">Inscription</h1>
                <p class="text-slate-400 text-sm">Créez votre espace bien-être</p>
            </div>

            @if($errors->any())
                <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-lg px-4 py-3 mb-6 text-sm">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-5">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-semibold text-slate-300">Nom</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name') }}"
                           placeholder="Votre nom"
                           required autofocus autocomplete="name"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-semibold text-slate-300">Adresse email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="votre@email.fr"
                           required autocomplete="username"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-semibold text-slate-300">Mot de passe</label>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••"
                           required autocomplete="new-password"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-300">Confirmer le mot de passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           placeholder="••••••••"
                           required autocomplete="new-password"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg px-4 py-2.5 text-sm transition">
                    Créer mon compte
                </button>

                <div class="text-center text-sm pt-2 border-t border-slate-700">
                    <a href="{{ route('login') }}"
                       class="text-emerald-400 hover:text-emerald-300 transition">
                        Déjà inscrit ? Se connecter
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
