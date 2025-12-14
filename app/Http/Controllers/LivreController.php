<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\CategorieLivre;
use Illuminate\Http\Request;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Livre::with(['categorie', 'reservations' => function($q) {
                $q->whereIn('etat', ['en_attente', 'validee']);
            }]);

            // Recherche par titre ou auteur
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('titre', 'like', "%{$search}%")
                      ->orWhere('auteur', 'like', "%{$search}%");
                });
            }

            // Filtrage par catégorie
            if ($request->has('categorie') && $request->categorie) {
                $query->where('categorie_livre_id', $request->categorie);
            }

            $livres = $query->paginate(12);
            $categories = CategorieLivre::all();

            // Pour chaque livre, déterminer si l'utilisateur actuel l'a réservé
            if (auth()->check()) {
                $userReservations = auth()->user()->reservations()
                    ->whereIn('etat', ['en_attente', 'validee'])
                    ->pluck('livre_id')
                    ->toArray();
                
                foreach ($livres as $livre) {
                    $livre->isReservedByCurrentUser = in_array($livre->id, $userReservations);
                }
            }

            return view('livres.index', compact('livres', 'categories'));
        } catch (\Exception $e) {
            return 'Erreur dans le contrôleur: ' . $e->getMessage() . ' - Ligne: ' . $e->getLine();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CategorieLivre::all();
        return view('livres.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_publication' => 'required|date',
            'categorie_livre_id' => 'required|exists:categorie_livres,id',
            'disponible' => 'boolean',
        ]);

        Livre::create($validated);

        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Livre $livre)
    {
        $livre->load('categorie', 'reservations');
        
        // Vérifier si l'utilisateur actuel a réservé ce livre
        if (auth()->check()) {
            $livre->isReservedByCurrentUser = auth()->user()->reservations()
                ->where('livre_id', $livre->id)
                ->whereIn('etat', ['en_attente', 'validee'])
                ->exists();
        }
        
        return view('livres.show', compact('livre'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livre $livre)
    {
        $categories = CategorieLivre::all();
        return view('livres.edit', compact('livre', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livre $livre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'auteur' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_publication' => 'required|date',
            'categorie_livre_id' => 'required|exists:categorie_livres,id',
            'disponible' => 'boolean',
        ]);

        $livre->update($validated);

        return redirect()->route('livres.index')->with('success', 'Livre modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livre $livre)
    {
        $livre->delete();
        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès.');
    }
}
