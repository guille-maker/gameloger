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
public function game()
{
    return $this->belongsTo(Game::class);
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
        'progress' => 'nullable|integer',
        'comment' => 'nullable|string',
    ]);

    $game = Game::find($request->game_id);

    // Asignar imagen por título
    $imageMap = [
        'Zelda' => 'img/games/zelda.jpg',
        'Final Fantasy' => 'img/games/finalfantasy.jpg',
        'Pokemon' => 'img/games/pokemon.jpg',
        'Mario' => 'img/games/mario.jpg',
    ];

    $defaultImage = 'img/games/default.jpg';

    $matchedImage = collect($imageMap)->first(function ($url, $key) use ($game) {
        return str_contains(strtolower($game->title), strtolower($key));
    }) ?? $defaultImage;

    UserGame::create([
        'user_id' => auth()->id(),
        'game_id' => $game->id,
        'progress' => $request->progress,
        'comment' => $request->comment,
        'screenshot_url' => $matchedImage,
    ]);

    return redirect()->route('profile.edit')->with('success', 'Juego añadido con imagen');
}


    // Mostrar formulario para editar progreso o comentario
   public function edit($id)
{
    $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
    return response()->json($userGame);
}

    // Actualizar los datos del juego vinculado
    public function update(Request $request, $id)
    {
        $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
            'screenshot_url' => 'nullable|url',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userGame->update([
            'progress' => $request->progress,
            'screenshot_url' => $request->screenshot_url,
            'comment' => $request->comment,
        ]);

        return redirect()->route('user-games.index')->with('success', 'Juego actualizado.');
    }

    // Eliminar el juego del perfil
    public function destroy($id)
    {
        $userGame = UserGame::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $userGame->delete();

        return redirect()->route('user-games.index')->with('success', 'Juego eliminado de tu perfil.');
    }
}
