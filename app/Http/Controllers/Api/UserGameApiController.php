<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGame;

class UserGameApiController extends Controller
{
    public function index()
    {
        return response()->json(Auth::user()->userGames);
    }

    public function show($id)
    {
        $game = Auth::user()->userGames()->findOrFail($id);
        return response()->json($game);
    }

    public function update(Request $request, $id)
    {
        $game = Auth::user()->userGames()->findOrFail($id);
        $game->update($request->only([
            'comment', 'hours_played', 'difficulty', 'completed', 'started_at', 'finished_at'
        ]));

        return response()->json([
            'message' => 'Juego actualizado',
            'data' => $game
        ]);
    }

    public function destroy($id)
    {
        $game = Auth::user()->userGames()->findOrFail($id);
        $game->delete();

        return response()->json(['message' => 'Juego eliminado']);
    }
}
