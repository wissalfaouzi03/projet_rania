<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_livres' => Livre::count(),
            'livres_disponibles' => Livre::where('disponible', true)->count(),
            'total_utilisateurs' => User::where('role', 'user')->count(),
            'total_reservations' => Reservation::count(),
            'reservations_en_attente' => Reservation::where('etat', 'en_attente')->count(),
            'reservations_validees' => Reservation::where('etat', 'validee')->count(),
        ];

        $recent_reservations = Reservation::with(['user', 'livre'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_reservations'));
    }
}
