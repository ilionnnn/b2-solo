<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CESIZen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&family=Lora:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col">

<nav class="bg-emerald-700 px-8 py-4 flex justify-between items-center shadow-md">
    <a href="/" class="font-lora text-xl font-semibold text-white">CESIZen</a>
    <div class="flex items-center gap-6 text-sm">
        <a href="/" class="text-emerald-100 hover:text-white transition">Accueil</a>
        <a href="{{ route('exercice_respiration.index') }}" class="text-emerald-100 hover:text-white transition">Exercices</a>
        <a href="{{ route('information.index') }}" class="text-emerald-100 hover:text-white transition">Informations</a>
        @auth
            <a href="/profile" class="text-emerald-100 hover:text-white transition">Profil</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button class="text-emerald-100 hover:text-white border border-emerald-400 rounded px-3 py-1 text-sm transition hover:border-white">
                    Déconnexion
                </button>
            </form>
        @endauth
        @guest
            <a href="/login" class="text-emerald-100 hover:text-white transition">Connexion</a>
            <a href="/register" class="bg-white text-emerald-700 font-semibold rounded px-4 py-1.5 text-sm hover:bg-emerald-50 transition">Inscription</a>
        @endguest
    </div>
</nav>

<main class="flex-grow w-full max-w-6xl mx-auto px-6 py-10">
    @yield('content')
</main>

<footer class="bg-slate-800 text-slate-400 text-center py-4 text-sm">
    CESIZen © 2026
</footer>

</body>
</html>
