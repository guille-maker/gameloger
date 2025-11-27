<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserGameController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Game;

Route::get('/juegos', [GameController::class, 'index'])->name('games.index');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])
    ->name('activities.destroy')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    // Perfil personal (avatar + descripción)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    // Lista de juegos del usuario (renombrada a /mis-juegos pero mantiene todas las rutas)
    Route::get('/mis-juegos', [UserGameController::class, 'index'])->name('user-games.index');
    Route::get('/mis-juegos/create', [UserGameController::class, 'create'])->name('user-games.create');
    Route::post('/mis-juegos', [UserGameController::class, 'store'])->name('user-games.store');
    Route::get('/mis-juegos/{id}/edit', [UserGameController::class, 'edit'])->name('user-games.edit');
    Route::put('/mis-juegos/{id}', [UserGameController::class, 'update'])->name('user-games.update');
    Route::delete('/mis-juegos/{id}', [UserGameController::class, 'destroy'])->name('user-games.destroy');
    Route::resource('user-games', UserGameController::class)->middleware('auth'); // 👈 Mantengo tu resource original

    // Juegos generales
    Route::resource('games', GameController::class);

    // Sesiones de juego
    Route::resource('game-sessions', GameSessionController::class);

    // Posts
    Route::resource('posts', PostController::class);

    // Comentarios
    Route::resource('comments', CommentController::class);

    // Follows
    Route::resource('follows', FollowController::class);

    // API búsqueda de juegos
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
