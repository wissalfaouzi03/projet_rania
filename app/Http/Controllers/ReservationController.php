<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $reservations = Reservation::with(['user', 'livre'])->latest()->paginate(15);
        } else {
            $reservations = Auth::user()->reservations()->with('livre')->latest()->paginate(15);
        }

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'livre_id' => 'required|exists:livres,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $livre = Livre::findOrFail($validated['livre_id']);

        // Vérifier si le livre est disponible
        if (!$livre->disponible) {
            return back()->withErrors(['livre_id' => 'Ce livre n\'est pas disponible pour le moment.'])->withInput();
        }

        // Vérifier si l'utilisateur a déjà une réservation active
        $reservationActive = Auth::user()->reservations()
            ->whereIn('etat', ['en_attente', 'validee'])
            ->first();

        if ($reservationActive) {
            $dateDebut = $reservationActive->date_debut->format('d/m/Y');
            $dateFin = $reservationActive->date_fin->format('d/m/Y');
            $message = "Vous ne pouvez réserver qu'un seul livre à la fois. Vous avez déjà une réservation active du {$dateDebut} au {$dateFin}. Veuillez attendre la fin de cette période ou annuler votre réservation actuelle avant d'en créer une nouvelle.";
            return back()->withErrors(['message' => $message])->withInput();
        }

        // Vérifier si l'utilisateur n'a pas déjà réservé ce livre spécifique
        $dejaReserve = Auth::user()->reservations()
            ->where('livre_id', $validated['livre_id'])
            ->whereIn('etat', ['en_attente', 'validee'])
            ->exists();

        if ($dejaReserve) {
            return back()->withErrors(['livre_id' => 'Vous avez déjà réservé ce livre.'])->withInput();
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'livre_id' => $validated['livre_id'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'etat' => 'en_attente',
        ]);

        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès. Elle est en attente de validation par l\'administrateur.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        // Vérifier les permissions : admin ou propriétaire de la réservation
        if (!Auth::user()->isAdmin() && Auth::id() !== $reservation->user_id) {
            abort(403, 'Accès non autorisé.');
        }
        
        $reservation->load(['user', 'livre']);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Vérifier les permissions : admin ou propriétaire (si en attente)
        if (Auth::user()->isAdmin()) {
            // Admin peut supprimer n'importe quelle réservation
        } elseif (Auth::id() === $reservation->user_id && $reservation->etat === 'en_attente') {
            // Utilisateur peut supprimer sa propre réservation si elle est en attente
        } else {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette réservation.');
        }
        
        $wasValidee = $reservation->etat === 'validee';
        $livre = $reservation->livre;
        
        $reservation->delete();
        
        // Si la réservation était validée, remettre le livre disponible
        if ($wasValidee) {
            $livre->update(['disponible' => true]);
        }
        
        return redirect()->route('reservations.index')->with('success', 'Réservation annulée avec succès.');
    }

    /**
     * Valider une réservation (admin seulement)
     */
    public function valider(Reservation $reservation)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $reservation->update(['etat' => 'validee']);
        $reservation->livre->update(['disponible' => false]);

        return redirect()->route('reservations.index')->with('success', 'Réservation validée.');
    }

    /**
     * Annuler une réservation (admin seulement)
     */
    public function annuler(Reservation $reservation)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $wasValidee = $reservation->etat === 'validee';
        $reservation->update(['etat' => 'annulee']);
        
        // Si la réservation était validée, remettre le livre disponible
        if ($wasValidee) {
            $reservation->livre->update(['disponible' => true]);
        }

        return redirect()->route('reservations.index')->with('success', 'Réservation annulée avec succès.');
    }
}
