<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Emotion;

class EmotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Emotion::insert([
            ['name' => 'Joie', 'color' => '#22c55e'],
            ['name' => 'Stress', 'color' => '#ef4444'],
            ['name' => 'Fatigue', 'color' => '#6366f1'],
            ['name' => 'Colère', 'color' => '#f97316'],
            ['name' => 'Tristesse', 'color' => '#3b82f6'],
        ]);
    }
}
