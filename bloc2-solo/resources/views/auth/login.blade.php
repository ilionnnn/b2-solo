@extends('layouts.app')

@section('title', 'Connexion')

@section('content')

    <div class="flex justify-center items-center min-h-[70vh]">
        <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 w-full max-w-md">

            <div class="text-center mb-8">
                <h1 class="font-lora text-3xl font-semibold text-white mb-2">Connexion</h1>
                <p class="text-slate-400 text-sm">Accédez à votre espace bien-être</p>
            </div>

            @if(session('error'))
                <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-lg px-4 py-3 mb-6 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-900/40 border border-red-700 text-red-300 rounded-lg px-4 py-3 mb-6 text-sm">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                @csrf

                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-semibold text-slate-300">Adresse email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="votre@email.fr"
                           required autofocus autocomplete="username"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-semibold text-slate-300">Mot de passe</label>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••"
                           required autocomplete="current-password"
                           class="bg-slate-900 border border-slate-600 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-slate-200 placeholder-slate-500 rounded-lg px-4 py-2.5 text-sm outline-none transition">
                </div>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="remember"
                           class="w-4 h-4 rounded accent-emerald-500">
                    <span class="text-sm text-slate-300">Se souvenir de moi</span>
                </label>

                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-lg px-4 py-2.5 text-sm transition">
                    Se connecter
                </button>

                <div class="flex items-center justify-between text-sm pt-2 border-t border-slate-700">
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-slate-400 hover:text-slate-200 transition">
                            Mot de passe oublié ?
                        </a>
                    @endif
                    <a href="{{ route('register') }}"
                       class="text-emerald-400 hover:text-emerald-300 transition">
                        Pas encore inscrit ?
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
