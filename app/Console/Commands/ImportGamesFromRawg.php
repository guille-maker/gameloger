<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Game;

class ImportGamesFromRawg extends Command
{
    protected $signature = 'import:games-from-rawg';
    protected $description = 'Importa videojuegos desde la API de RAWG';

    public function handle()
{
    $apiKey = env('RAWG_API_KEY');
    $page = 1;
    $totalImported = 0;

    do {
        $response = Http::get("https://api.rawg.io/api/games", [
            'key' => $apiKey,
            'page_size' => 40,
            'page' => $page,
        ]);

        if ($response->failed()) {
            $this->error("Error en la página $page");
            break;
        }

        $games = $response->json()['results'];

        foreach ($games as $rawgGame) {
            Game::updateOrCreate(
                ['slug' => $rawgGame['slug']],
                [
                    'slug' => $rawgGame['slug'],
                    'title' => $rawgGame['name'],
                    'description' => $rawgGame['released'] ?? '',
                    'cover_url' => $rawgGame['background_image'] ?? '',
                    'platform' => $rawgGame['platforms'][0]['platform']['name'] ?? 'Desconocida',
                    'genre' => $rawgGame['genres'][0]['name'] ?? 'Sin género',
                ]
            );
            $totalImported++;
        }

        $this->info("Página $page importada con " . count($games) . " juegos.");
        $page++;

    } while (count($games) > 0);

    $this->info("Importación completa. Total de juegos importados: $totalImported");
}
}
