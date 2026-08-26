@extends('layouts.app')

@section('title', 'Mentions légales')

@section('content')
<div class="max-w-3xl mx-auto py-10 space-y-6">
    <h1 class="font-lora text-3xl font-semibold text-white">Mentions légales</h1>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">Éditeur</h2>
        <p>CESIZen — plateforme de gestion du stress et d'information sur la santé mentale.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">Hébergement</h2>
        <p>Application hébergée sur une infrastructure européenne (voir le plan de déploiement du projet).</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">Propriété intellectuelle</h2>
        <p>L'ensemble des contenus (textes, visuels, code) est la propriété de CESIZen, sauf mention contraire.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">Données personnelles</h2>
        <p>Le traitement de vos données est décrit dans la
        <a href="{{ route('confidentialite') }}" class="text-emerald-400 underline">politique de confidentialité</a>.</p>
    </section>
</div>
@endsection
