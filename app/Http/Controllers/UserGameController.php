<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\UserGame;
use Illuminate\Support\Facades\Auth;

class UserGameController extends Controller
{
    // Mostrar todos los juegos añadidos por el usuario
    public function index()
    {
        $userGames = Auth::user()->userGames()->with('game')->latest()->get();
        return view('user_games.index', compact('userGames'));
    }

    // Mostrar formulario para añadir un juego al perfil
    public function create()
    {
        $games = Game::orderBy('title')->get();
        return view('user_games.create', compact('games'));
    }

    // Guardar el juego vinculado al usuario
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'hours_played' => 'nullable|integer|min:0',
            'difficulty' => 'nullable|string|max:255',
            'progress' => 'nullable|integer|min:0|max:100',
            'completed' => 'nullable|boolean',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date|after_or_equal:started_at',
            'comment' => 'nullable|string',
        ]);

        $game = Game::findOrFail($request->game_id);

        UserGame::create([
    'user_id' => auth()->id(),
    'game_id' => $game->id,
    'comment' => $request->comment,
    'screenshot_url' => $game->cover_url,
    'hours_played' => $request->hours_played,
    'difficulty' => $request->difficulty,
    'progress' => $request->progress,
    'completed' => $request->completed ?? false,
    'started_at' => now(), // 👈 se guarda automáticamente la fecha actual
    'finished_at' => null, // opcional, se deja vacío
]);


        return redirect()->route('profile.edit')->with('success', 'Juego añadido con éxito');
    }

    // Mostrar formulario para editar un juego del perfil
    public function edit($id)
    {
        $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user_games.edit', [
            'userGame' => $userGame,
            'user' => Auth::user(), // 👈 esto soluciona el error
        ]);

    }


    // Actualizar los datos del juego vinculado
    public function update(Request $request, $id)
    {
        $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'screenshot_url' => 'nullable|url',
            'comment' => 'nullable|string|max:1000',
            'hours_played' => 'nullable|integer',
            'completed' => 'nullable|boolean',
            'difficulty' => 'nullable|string',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
        ]);

        $userGame->update([
            'comment' => $request->comment,
            'hours_played' => $request->hours_played,
            'completed' => $request->completed,
            'difficulty' => $request->difficulty,
            'started_at' => $request->started_at,
            'finished_at' => $request->finished_at,
        ]);

        return redirect()->route('profile.edit')->with('success', 'Juego actualizado.');
    }

    // Eliminar el juego del perfil
    public function destroy($id)
    {
        $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $userGame->delete();

        return redirect()->route('profile.edit')->with('success', 'Juego eliminado de tu perfil.');
    }
}
