<?php

namespace Database\Seeders;

use App\Models\Livre;
use App\Models\CategorieLivre;
use Illuminate\Database\Seeder;

class LivreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = CategorieLivre::all();

        $livres = [
            [
                'titre' => 'Le Seigneur des Anneaux',
                'auteur' => 'J.R.R. Tolkien',
                'description' => 'Une épopée fantastique dans la Terre du Milieu.',
                'date_publication' => '1954-07-29',
                'categorie_livre_id' => $categories->where('nom', 'Roman')->first()->id,
                'disponible' => true,
            ],
            [
                'titre' => '1984',
                'auteur' => 'George Orwell',
                'description' => 'Un roman dystopique sur la surveillance et le totalitarisme.',
                'date_publication' => '1949-06-08',
                'categorie_livre_id' => $categories->where('nom', 'Science-Fiction')->first()->id,
                'disponible' => true,
            ],
            [
                'titre' => 'Sapiens : Une brève histoire de l\'humanité',
                'auteur' => 'Yuval Noah Harari',
                'description' => 'Une histoire de l\'humanité depuis l\'âge de pierre jusqu\'à nos jours.',
                'date_publication' => '2011-01-01',
                'categorie_livre_id' => $categories->where('nom', 'Histoire')->first()->id,
                'disponible' => true,
            ],
            [
                'titre' => 'Clean Code',
                'auteur' => 'Robert C. Martin',
                'description' => 'Un manuel de programmation agile pour écrire du code propre.',
                'date_publication' => '2008-08-01',
                'categorie_livre_id' => $categories->where('nom', 'Informatique')->first()->id,
                'disponible' => true,
            ],
            [
                'titre' => 'L\'Étranger',
                'auteur' => 'Albert Camus',
                'description' => 'Un roman philosophique sur l\'absurdité de l\'existence.',
                'date_publication' => '1942-06-01',
                'categorie_livre_id' => $categories->where('nom', 'Philosophie')->first()->id,
                'disponible' => true,
            ],
        ];

        foreach ($livres as $livre) {
            Livre::create($livre);
        }
    }
}
