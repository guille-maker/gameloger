<?php
namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class GameController extends Controller
{

public function index(Request $request)
{
    $query = Game::query();

    if ($request->filled('genre')) {
        $query->where('genre', $request->genre);
    }

    if ($request->filled('platform')) {
        $query->where('platform', $request->platform);
    }

    $games = $query->orderBy('title')->paginate(60);

    $availableGenres = Game::select('genre')
        ->distinct()
        ->whereNotNull('genre')
        ->orderBy('genre')
        ->pluck('genre');

    $availablePlatforms = Game::select('platform')
        ->distinct()
        ->whereNotNull('platform')
        ->orderBy('platform')
        ->pluck('platform');

    return view('games.index', compact('games', 'availableGenres', 'availablePlatforms'));
}

    // Mostrar el formulario para crear un juego
    public function create()
    {
        return view('games.create');
    }


public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'platform' => 'required|string|max:255',
        'genre' => 'nullable|string|max:255',
        'cover_url' => 'nullable|url',
    ]);

    $data = $request->all();
    $data['slug'] = Str::slug($data['title']); // ← genera el slug

    Game::create($data);

    return redirect()->route('games.index')->with('success', 'Juego creado correctamente.');
}

    // Mostrar un juego específico
    public function show(string $id)
    {
        $game = Game::findOrFail($id);
        return view('games.show', compact('game'));
    }

    // Mostrar el formulario para editar un juego
    public function edit(string $id)
    {
        $game = Game::findOrFail($id);
        return view('games.edit', compact('game'));
    }

    // Actualizar un juego existente
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'platform' => 'required|string|max:255',
            'genre' => 'nullable|string|max:255',
        ]);

        $game = Game::findOrFail($id);
        $game->update($request->all());

        return redirect()->route('games.index')->with('success', 'Juego actualizado correctamente.');
    }

    // Eliminar un juego
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->route('games.index')->with('success', 'Juego eliminado correctamente.');
    }
}
