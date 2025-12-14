<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un administrateur
        User::create([
            'name' => 'Administrateur',
            'email' => 'rania@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Créer quelques utilisateurs
        User::create([
            'name' => 'Rania Faouzi',
            'email' => 'rania@user.com',
            'password' => Hash::make('rania'),
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Wissal Faouzi',
            'email' => 'wissal@Faouzi.com',
            'password' => Hash::make('wissal'),
            'role' => 'user',
        ]);
    }
}
