<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CESIZen</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-[#0f172a] text-white min-h-screen flex flex-col">

<!-- NAVBAR -->
<nav class="bg-emerald-600 px-8 py-4 flex justify-between items-center shadow-lg">

    <h1 class="text-xl font-semibold">
        CESIZen
    </h1>

    <div class="flex gap-6 text-sm">

        <a href="/">Accueil</a>
        <a href="/exercises">Exercices</a>
        <a href="/emotions">Tracker</a>

        @auth
            <a href="/profile">Profil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>Logout</button>
            </form>
        @endauth

        @guest
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        @endguest

    </div>

</nav>

<!-- CONTENT -->
<main class="flex-grow p-8 max-w-6xl mx-auto w-full">

    @yield('content')

</main>

<!-- FOOTER -->
<footer class="bg-gray-800 text-center py-4 text-sm">

    CESIZen © 2026

</footer>

</body>

</html>
