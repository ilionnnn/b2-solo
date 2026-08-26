@extends('layouts.app')

@section('title', 'Support')

@section('content')
<div class="max-w-3xl mx-auto py-10 space-y-6">
    <h1 class="font-lora text-3xl font-semibold text-white">Support & assistance</h1>
    <p>Vous rencontrez un problème ou souhaitez proposer une amélioration ?</p>

    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 space-y-3">
        <h2 class="text-lg font-semibold text-emerald-400">Signaler une anomalie ou une évolution</h2>
        <p class="text-slate-300 text-sm">Les demandes sont suivies via notre outil de ticketing.
        Merci de préciser : ce que vous attendiez, ce qui s'est produit, et les étapes pour reproduire.</p>
        <a href="{{ route('contact') }}"
           class="inline-block bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-2 rounded transition text-sm">
            Nous contacter
        </a>
    </div>

    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 space-y-2">
        <h2 class="text-lg font-semibold text-emerald-400">Urgence santé mentale</h2>
        <p class="text-slate-300 text-sm">CESIZen ne remplace pas un professionnel de santé. En cas de
        détresse, contactez le 3114 (numéro national de prévention du suicide, gratuit, 24h/24).</p>
    </div>
</div>
@endsection
