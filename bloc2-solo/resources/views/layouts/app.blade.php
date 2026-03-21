<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CESIZen')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Lora:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
    </style>
</head>

<body class="bg-slate-900 text-slate-200 min-h-screen flex flex-col">

{{-- NAVBAR --}}
<nav class="bg-slate-800 border-b border-slate-700 px-8 py-4 flex justify-between items-center">

    <a href="/" class="font-lora text-xl font-semibold text-white flex items-center gap-2">
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="text-emerald-400">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
            <path d="M12 8v4m0 4h.01"/>
        </svg>
        CESIZen
    </a>

    <div class="flex items-center gap-6 text-sm">
        <a href="/" class="text-slate-400 hover:text-white transition">Accueil</a>
        <a href="{{ route('exercice_respiration.index') }}" class="text-slate-400 hover:text-white transition">Exercices</a>
        <a href="{{ route('information.index') }}" class="text-slate-400 hover:text-white transition">Informations</a>

        @auth
            <a href="{{ route('profile.index') }}" class="text-slate-400 hover:text-white transition flex items-center gap-1.5">
                <div class="w-6 h-6 rounded-full bg-emerald-800 border border-emerald-600 flex items-center justify-center text-xs font-bold text-emerald-300">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                {{ auth()->user()->name }}
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-slate-400 hover:text-white border border-slate-600 hover:border-slate-400 rounded-lg px-3 py-1.5 text-sm transition">
                    Déconnexion
                </button>
            </form>
        @endauth

        @guest
            <a href="/login"
               class="text-slate-400 hover:text-white transition">
                Connexion
            </a>
            <a href="/register"
               class="bg-emerald-700 hover:bg-emerald-600 text-white font-semibold rounded-lg px-4 py-1.5 text-sm transition">
                Inscription
            </a>
        @endguest
    </div>

</nav>

{{-- CONTENT --}}
<main class="flex-grow w-full max-w-6xl mx-auto px-6 py-10">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="bg-slate-800 border-t border-slate-700 text-center py-4 text-sm text-slate-500">
    CESIZen © 2026 — Votre espace bien-être
</footer>

</body>
</html>
