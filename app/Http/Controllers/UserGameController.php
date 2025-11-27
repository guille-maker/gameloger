<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\UserGame;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;

class UserGameController extends Controller
{
    // Mostrar todos los juegos añadidos por el usuario
    public function index()
    {
         $userGames = Auth::user()->userGames()->latest()->get();
    $user = Auth::user();

    return view('user_games.index', compact('userGames', 'user'));
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
            'status' => 'jugando',
            'comment' => $request->comment,
            'screenshot_url' => $game->cover_url,
            'hours_played' => $request->hours_played,
            'difficulty' => $request->difficulty,
            'progress' => $request->progress,
            'completed' => $request->completed ?? false,
            'started_at' => now(), // 👈 se guarda automáticamente la fecha actual
            'finished_at' => null, // opcional, se deja vacío
        ]);
        Activity::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'type' => 'added_game',
           'description' => 'empezó a jugar ' . $game->title . '',

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
        'status' => 'required|string|in:jugando,pausa,terminado,rejugando,completado,dejado,abandonado',
        'screenshot_url' => 'nullable|url',
        'comment' => 'nullable|string|max:1000',
        'hours_played' => 'nullable|integer',
        'completed' => 'nullable|boolean',
        'difficulty' => 'nullable|string',
        'started_at' => 'nullable|date',
        'finished_at' => 'nullable|date',
    ]);

    // Guardar el status anterior
    $oldStatus = $userGame->status;

    // Actualizar datos
    $userGame->update([
        'status' => $request->status,
        'comment' => $request->comment,
        'hours_played' => $request->hours_played,
        'completed' => $request->completed,
        'difficulty' => $request->difficulty,
        'started_at' => $request->started_at,
        'finished_at' => $request->finished_at,
    ]);

    // Registrar actividad SOLO si cambió el status
   if ($oldStatus !== $request->status) {
    $type = match ($request->status) {
        'jugando'   => 'started_game',
        'terminado' => 'finished_game',
        'dejado', 'abandonado' => 'left_game',
        'pausa'     => 'paused_game',
        default     => 'updated_game',
    };

    $description = match ($request->status) {
    'jugando'   => 'empezó a jugar ' . $userGame->game->title,
    'terminado' => 'terminó ' . $userGame->game->title,
    'dejado', 'abandonado' => 'dejó de jugar ' . $userGame->game->title,
    'pausa'     => 'puso en pausa ' . $userGame->game->title,
    default     => 'actualizó ' . $userGame->game->title,
};


    Activity::create([
        'user_id' => auth()->id(),
        'game_id' => $userGame->game_id,
        'type' => $type,
        'description' => $description,
        'image_url' => $userGame->screenshot_url,
    ]);
}

    

    return redirect()->route('profile.edit')->with('success', 'Juego actualizado.');
}



    // Eliminar el juego del perfil
    public function destroy($id)
    {
        $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $userGame->delete();

        return redirect()->route('profile.edit')->with('success', 'Juego eliminado de tu perfil.');
    
    }

    public function leave($id)
    {
        $userGame = UserGame::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $userGame->update([
            'status' => 'dejado',
            'finished_at' => now(),
        ]);

        // Registrar actividad
        Activity::create([
            'user_id' => auth()->id(),
            'game_id' => $userGame->game_id,
            'type' => 'left_game',
           'description' => 'dejó de jugar ' . $userGame->game->title,

        ]);

        return redirect()->route('profile.edit')->with('success', 'Has marcado el juego como "dejé de jugarlo".');
    }

}

