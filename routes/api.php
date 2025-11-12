<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserGameApiController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8'
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    return response()->json([
        'message' => 'Usuario creado correctamente',
        'token' => $user->createToken('api-token')->plainTextToken
    ], 201);
});

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    return response()->json([
        'token' => $request->user()->createToken('api-token')->plainTextToken
    ]);
});
use App\Http\Controllers\GameController;

Route::get('/games', [GameController::class, 'index']);

use App\Http\Controllers\SwaggerController;

Route::get('/test', [SwaggerController::class, 'test']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn(Request $request) => $request->user());
    Route::get('/user-games', [UserGameApiController::class, 'index']);
    Route::post('/user-games', [UserGameApiController::class, 'store']);
    Route::get('/user-games/{id}', [UserGameApiController::class, 'show']);
    Route::put('/user-games/{id}', [UserGameApiController::class, 'update']);
    Route::delete('/user-games/{id}', [UserGameApiController::class, 'destroy']);
});
