<?php

namespace Database\Seeders;

use App\Models\CategorieLivre;
use Illuminate\Database\Seeder;

class CategorieLivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nom' => 'Roman', 'description' => 'Romans et fictions'],
            ['nom' => 'Science-Fiction', 'description' => 'Livres de science-fiction'],
            ['nom' => 'Histoire', 'description' => 'Livres historiques'],
            ['nom' => 'Biographie', 'description' => 'Biographies et mémoires'],
            ['nom' => 'Informatique', 'description' => 'Livres sur l\'informatique et la programmation'],
            ['nom' => 'Philosophie', 'description' => 'Livres de philosophie'],
            ['nom' => 'Politique', 'description' => 'Livres sur la politique'],
            ['nom' => 'Économie', 'description' => 'Livres sur l\'économie'],
        ];

        foreach ($categories as $categorie) {
            CategorieLivre::create($categorie);
        }
    }
}
