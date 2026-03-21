<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExerciceRespiration;

class ExerciceRespirationSeeder extends Seeder
{
    public function run(): void
    {
        $exercices = [
            [
                'nom'               => 'Relaxation profonde 7-4-8',
                'description'       => 'Technique développée par le Dr Andrew Weil. L\'apnée de 4 secondes permet de charger le sang en oxygène et de calmer le système nerveux. Idéal pour s\'endormir ou gérer un stress intense.',
                'duree_inspiration' => 7,
                'duree_apnee'       => 4,
                'duree_expiration'  => 8,
                'duree_totale'      => (7 + 4 + 8) * 5,
                'nombre_cycles'     => 5,
                'type'              => '7-4-8',
                'public'            => true,
                'user_id'           => 1,
            ],
            [
                'nom'               => 'Cohérence cardiaque 5-5',
                'description'       => 'La cohérence cardiaque classique à 6 respirations par minute. Inspire et expire à égalité pendant 5 minutes pour réduire le cortisol, stabiliser la tension artérielle et améliorer la concentration.',
                'duree_inspiration' => 5,
                'duree_apnee'       => 0,
                'duree_expiration'  => 5,
                'duree_totale'      => (5 + 5) * 5,
                'nombre_cycles'     => 5,
                'type'              => '5-5',
                'public'            => true,
                'user_id'           => 1,
            ],
            [
                'nom'               => 'Anti-stress 4-6',
                'description'       => 'L\'expiration plus longue que l\'inspiration active le système nerveux parasympathique et réduit rapidement l\'anxiété. À pratiquer dès que vous ressentez une montée de stress.',
                'duree_inspiration' => 4,
                'duree_apnee'       => 0,
                'duree_expiration'  => 6,
                'duree_totale'      => (4 + 6) * 5,
                'nombre_cycles'     => 5,
                'type'              => '4-6',
                'public'            => true,
                'user_id'           => 1,
            ],
        ];

        foreach ($exercices as $exercice) {
            ExerciceRespiration::firstOrCreate(
                ['nom' => $exercice['nom']],
                $exercice
            );
        }
    }
}
