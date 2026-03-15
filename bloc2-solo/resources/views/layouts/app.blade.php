<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CESIZen</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-900 text-white min-h-screen flex flex-col">

<!-- NAVBAR -->

<nav class="bg-emerald-700 px-6 py-3 flex justify-between items-center">

    <div class="font-bold text-lg">
        CESIZen
    </div>

    <div class="flex gap-4 text-sm">

        <a href="/" class="hover:underline">Accueil</a>

        <a href="/exercises" class="hover:underline">Exercices</a>

        <a href="/emotions" class="hover:underline">Tracker</a>

        <a href="/profile" class="hover:underline">Profil</a>

        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="hover:underline">Déconnexion</button>
            </form>
        @endauth

        @guest
            <a href="/login" class="hover:underline">Connexion</a>
            <a href="/register" class="hover:underline">Inscription</a>
        @endguest

    </div>

</nav>

<!-- MAIN CONTENT -->

<main class="flex-grow">

    <div class="max-w-6xl mx-auto p-6">

        @yield('content')

    </div>

</main>

<!-- FOOTER -->

<footer class="bg-gray-800 text-center text-sm py-4">

    <p>Mentions légales</p>
    <p>Contact</p>
    <p>Liens utiles</p>
    <p>CGU</p>

</footer>

</body>
