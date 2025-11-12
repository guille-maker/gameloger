<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $games = $user ? $user->games : collect(); // evita error si no hay usuario
        return view('home', compact('games'));
    }
}
