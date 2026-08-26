@extends('layouts.app')

@section('title', 'Politique de confidentialité')

@section('content')
<div class="max-w-3xl mx-auto py-10 space-y-6">
    <h1 class="font-lora text-3xl font-semibold text-white">Politique de confidentialité</h1>
    <p class="text-slate-400 text-sm">Dernière mise à jour : {{ now()->translatedFormat('d F Y') }}</p>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">1. Responsable du traitement</h2>
        <p>L'application CESIZen est éditée par CESIZen. Pour toute question relative à vos données
        personnelles, vous pouvez contacter le délégué à la protection des données (DPO) via la
        page <a href="{{ route('contact') }}" class="text-emerald-400 underline">contact</a>.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">2. Données collectées</h2>
        <ul class="list-disc list-inside space-y-1 text-slate-300">
            <li>Données de compte : nom, adresse e-mail, mot de passe (haché).</li>
            <li>Données d'usage : exercices consultés, favoris, contenus du tracker d'émotions.</li>
            <li>Données techniques : journaux de connexion strictement nécessaires à la sécurité.</li>
        </ul>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">3. Finalités et base légale</h2>
        <p>Les données sont traitées pour fournir le service (exécution du contrat), assurer la
        sécurité (intérêt légitime) et, lorsque requis, sur la base de votre <strong>consentement</strong>
        recueilli à l'inscription.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">4. Durée de conservation</h2>
        <p>Les données de compte sont conservées tant que le compte est actif, puis supprimées ou
        anonymisées dans un délai de 12 mois après la dernière activité ou après demande de suppression.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">5. Vos droits (RGPD)</h2>
        <p>Conformément aux articles 15 à 22 du RGPD, vous disposez d'un droit d'accès, de
        rectification, d'effacement, de limitation, d'opposition et de portabilité de vos données.
        Vous pouvez exercer l'effacement directement depuis votre
        <a href="{{ route('profile.edit') }}" class="text-emerald-400 underline">espace profil</a>
        (« Supprimer mon compte ») ou en nous contactant.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">6. Sécurité</h2>
        <p>Les mots de passe sont hachés (bcrypt), les échanges sont chiffrés via HTTPS/TLS et l'accès
        aux données d'administration est restreint par un contrôle de rôle.</p>
    </section>

    <section class="space-y-3">
        <h2 class="text-xl font-semibold text-emerald-400">7. Réclamation</h2>
        <p>Vous pouvez introduire une réclamation auprès de la CNIL (<a href="https://www.cnil.fr"
        class="text-emerald-400 underline" rel="noopener noreferrer" target="_blank">www.cnil.fr</a>).</p>
    </section>
</div>
@endsection
