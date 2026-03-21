<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Information;

class InformationSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'titre'   => 'Mentions légales',
                'contenu' => "Ce site est édité par l'association CESIZen.\n\nDirecteur de publication : Administrateur CESIZen\nHébergeur : OVH SAS, 2 rue Kellermann, 59100 Roubaix\n\nPour toute question relative au site, vous pouvez nous contacter via le formulaire de contact.",
                'statut'  => 'publié',
                'user_id' => 1,
            ],
            [
                'titre'   => 'Conditions Générales d\'Utilisation',
                'contenu' => "L'utilisation de la plateforme CESIZen implique l'acceptation pleine et entière des présentes conditions générales d'utilisation.\n\nArticle 1 — Accès au service\nLe service est accessible à tout utilisateur disposant d'un accès internet.\n\nArticle 2 — Propriété intellectuelle\nL'ensemble des contenus présents sur ce site sont protégés par le droit d'auteur.",
                'statut'  => 'publié',
                'user_id' => 1,
            ],
            [
                'titre'   => 'Politique de confidentialité',
                'contenu' => "Dans le cadre de l'utilisation de nos services, nous collectons certaines données personnelles vous concernant.\n\nDonnées collectées : nom, prénom, adresse email.\nFinalité : gestion des comptes utilisateurs.\nConservation : les données sont conservées pendant la durée d'utilisation du compte.\n\nConformément au RGPD, vous disposez d'un droit d'accès, de rectification et de suppression de vos données.",
                'statut'  => 'publié',
                'user_id' => 1,
            ],
            [
                'titre'   => 'À propos de CESIZen',
                'contenu' => "CESIZen est une plateforme dédiée au bien-être mental et à la gestion du stress.\n\nNotre mission est de proposer des outils simples et accessibles pour aider chacun à mieux gérer ses émotions et son stress au quotidien.\n\nCréée en 2024, la plateforme propose des exercices de respiration guidés et des ressources pédagogiques.",
                'statut'  => 'publié',
                'user_id' => 1,
            ],
            [
                'titre'   => 'FAQ — Questions fréquentes',
                'contenu' => "Comment créer un compte ?\nRendez-vous sur la page d'inscription et remplissez le formulaire.\n\nComment pratiquer un exercice de respiration ?\nAccédez à la section Exercices, choisissez un exercice et suivez le cercle animé.\n\nMes données sont-elles sécurisées ?\nOui, vos données sont stockées de façon sécurisée et ne sont jamais revendues.",
                'statut'  => 'publié',
                'user_id' => 1,
            ],
            [
                'titre'   => 'Charte de bonne conduite',
                'contenu' => "En utilisant CESIZen, vous vous engagez à respecter les règles suivantes :\n\n- Respecter les autres membres\n- Ne pas publier de contenus illicites ou offensants\n- Utiliser la plateforme uniquement à des fins personnelles\n\nTout manquement pourra entraîner la suspension du compte.",
                'statut'  => 'brouillon',
                'user_id' => 1,
            ],
        ];

        foreach ($pages as $page) {
            Information::firstOrCreate(
                ['titre' => $page['titre']],
                $page
            );
        }
    }
}
