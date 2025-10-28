<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
    'title',
    'description',
    'cover_url',
    'slug',
    'progress',
    'status',
    'platform',
    'genre',
];
public function users()
{
    return $this->belongsToMany(User::class, 'user_games')
                ->withPivot('progress', 'comment', 'screenshot_url')
                ->withTimestamps();
}
public function userGames()
{
    return $this->hasMany(UserGame::class);
}

}
