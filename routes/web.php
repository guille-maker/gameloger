<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserGameController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Game;


Route::get('/juegos', [GameController::class, 'index'])->name('games.index');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 👇 Aquí van tus rutas protegidas
    Route::resource('games', GameController::class);
    Route::resource('game-sessions', GameSessionController::class);
    Route::resource('posts', PostController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('follows', FollowController::class);
    Route::get('/user-games', [UserGameController::class, 'index'])->name('user-games.index');
    Route::get('/user-games/create', [UserGameController::class, 'create'])->name('user-games.create');
    Route::post('/user-games', [UserGameController::class, 'store'])->name('user-games.store');
    Route::get('/user-games/{id}/edit', [UserGameController::class, 'edit'])->name('user-games.edit');
    Route::put('/user-games/{id}', [UserGameController::class, 'update'])->name('user-games.update');
    Route::delete('/user-games/{id}', [UserGameController::class, 'destroy'])->name('user-games.destroy');
    Route::resource('user-games', UserGameController::class)->middleware('auth');

    Route::get('/api/games/search', function (Request $request) {
    $query = $request->input('q');

    $games = Game::where('title', 'like', "%{$query}%")
        ->orderBy('title')
        ->limit(20)
        ->get();

    return response()->json($games->map(function ($game) {
        return [
            'value' => $game->id,
            'text' => $game->title . ' (' . $game->platform . ')',
        ];
    }));
})->middleware('auth');

});

require __DIR__.'/auth.php';
