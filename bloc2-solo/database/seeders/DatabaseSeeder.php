<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cesizenzen.fr'],
            [
                'name'     => 'Administrateur',
                'password' => bcrypt('password'),
                'role'     => 0,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@cesizenzen.fr'],
            [
                'name'     => 'test',
                'password' => bcrypt('password'),
                'role'     => 1,
            ]
        );

        $this->call([
            ExerciceRespirationSeeder::class,
            InformationSeeder::class,
        ]);
    }
}
