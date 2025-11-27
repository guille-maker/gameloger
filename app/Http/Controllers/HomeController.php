<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\Activity;

use App\Models\UserGame;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $games = $user ? $user->games : collect();

        // 👇 Aquí usamos directamente UserGame en vez de wherePivot
        $gamesStarted = $user
            ? UserGame::where('user_id', $user->id)
                ->where('status', 'jugando')
                ->with('game')
                ->get()
            : collect();

        $gamesPaused = $user
            ? UserGame::where('user_id', $user->id)
                ->where('status', 'pausa')
                ->with('game')
                ->get()
            : collect();

        // Juegos populares
        $popularGames = Game::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Actividad de amigos
        $activities = $user
            ? Activity::whereIn(
                'user_id',
                $user->friends()->pluck('users.id')->push($user->id)
            )
                ->latest()
                ->take(20)
                ->get()
            : collect();

        return view('home', compact('games', 'gamesStarted', 'gamesPaused', 'popularGames', 'activities'));
    }
}

