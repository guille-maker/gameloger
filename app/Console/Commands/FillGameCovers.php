<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FillGameCovers extends Command
{
    protected $signature = 'fill:game-covers {--download : Descargar la imagen y guardarla en storage/public} {--chunk=200 : Tamaño del chunk}';
    protected $description = 'Rellena las carátulas de los juegos que no tienen (usa RAWG).';

    public function handle()
    {
        $this->info("Iniciando proceso de rellenado de carátulas...");

        $chunkSize = (int) $this->option('chunk');

        try {
            Game::whereNull('cover_url')
                ->orWhere('cover_url', '')
                ->orWhere('cover_url', '0')
                ->orWhere('cover_url', ' ')
                ->chunkById($chunkSize, function ($games) {
                    foreach ($games as $game) {

                        // Doble comprobación: si ya tiene carátula, saltar
                        if (!empty($game->cover_url)) {
                            continue;
                        }

                        $this->info("Buscando imagen para: {$game->title}");

                        $image = $this->buscarImagen($game->title);

                        if ($image) {
                            if ($this->option('download')) {
                                try {
                                    $resp = Http::timeout(15)->get($image);
                                    if ($resp->successful()) {
                                        $ext = $this->getExtensionFromResponse($resp) ?? 'jpg';
                                        $filename = 'covers/' . md5($game->id . $game->title) . '.' . $ext;
                                        Storage::disk('public')->put($filename, $resp->body());
                                        $game->cover_url = Storage::url($filename);
                                    } else {
                                        $game->cover_url = $image;
                                    }
                                } catch (\Exception $e) {
                                    $game->cover_url = $image;
                                }
                            } else {
                                $game->cover_url = $image;
                            }

                            $game->save();
                            $this->info("✔ Imagen añadida a {$game->title}");
                        } else {
                            $this->warn("✖ No se encontró imagen para {$game->title}");
                        }

                        // Espera corta para no saturar la API
                        sleep(1);
                    }
                });
        } catch (\Exception $e) {
            $this->error("Error durante el proceso: " . $e->getMessage());
        }

        $this->info("Proceso completado.");
    }

   private function buscarImagen(string $nombre): ?string
{
    $apiKey = config('services.rawg.key') ?? env('RAWG_API_KEY');
    if (empty($apiKey)) return null;

    $original = trim($nombre);
    if ($original === '') return null;

    $endpoint = 'https://api.rawg.io/api/games';
    $variants = $this->generateTitleVariants($original);

    foreach ($variants as $variant) {
        // parámetros simples: no usar search_exact por ahora
        $params = [
            'key' => $apiKey,
            'search' => $variant,
            'page_size' => 20,
        ];

        try {
            $resp = Http::timeout(10)->get($endpoint, $params);
        } catch (\Throwable $e) {
            \Log::error("RAWG HTTP error for '{$variant}': " . $e->getMessage());
            continue;
        }

        // Loguear estado y primer trozo de body para depuración
        $status = $resp->status();
        $bodyPreview = substr($resp->body(), 0, 1000);
        \Log::info("RAWG search '{$variant}' status={$status} bodyPreview={$bodyPreview}");

        if (!$resp->successful()) {
            if ($status == 429) {
                sleep(2);
                continue;
            }
            continue;
        }

        $data = $resp->json();
        $results = $data['results'] ?? [];

        // Recorremos resultados y comparamos nombres normalizados
        foreach ($results as $r) {
            $rawName = $r['name'] ?? '';
            $normalizedRaw = $this->normalizeTitle($rawName);
            $normalizedQuery = $this->normalizeTitle($variant);

            // Log candidato
            \Log::info("RAWG candidate for '{$variant}': name='{$rawName}', slug='{$r['slug']}'");

            // Si el nombre normalizado contiene la query o viceversa, lo consideramos buena coincidencia
            if ($normalizedRaw === $normalizedQuery
                || str_contains($normalizedRaw, $normalizedQuery)
                || str_contains($normalizedQuery, $normalizedRaw)
            ) {
                // Priorizar background_image
                if (!empty($r['background_image'])) {
                    return $r['background_image'];
                }
                if (!empty($r['background_image_additional'])) {
                    return $r['background_image_additional'];
                }
            }
        }

        // Si no hay coincidencias claras, probar siguiente variante
        sleep(1);
    }

    // Registrar título no encontrado
    $this->logMissingCover($original);
    return null;
}

private function normalizeTitle(string $t): string
{
    $t = html_entity_decode($t);
    $t = mb_strtolower($t);
    $t = preg_replace('/[^\p{L}\p{N}\s]/u', '', $t); // quitar puntuación
    $t = preg_replace('/\s+/', ' ', $t);
    $t = trim($t);
    return $t;
}

    private function generateTitleVariants(string $title): array
    {
        $title = html_entity_decode($title);
        $variants = [];

        $variants[] = $title;

        $sufijos = [
            'demo', 'goodie pack', 'goodies', 'goodie', 'edition', 'deluxe', 'ultimate',
            'collection', 'bundle', 'dlc', 'hub', 'store', 'pack', 'classic',
            'complete', 'multiplayer', 'vr', 'demo version'
        ];
        $lower = mb_strtolower($title);
        foreach ($sufijos as $s) {
            if (Str::contains($lower, mb_strtolower($s))) {
                $clean = preg_replace('/\b' . preg_quote($s, '/') . '\b/i', '', $title);
                $clean = trim(preg_replace('/\s+/', ' ', $clean));
                if ($clean !== '') {
                    $variants[] = $clean;
                }
            }
        }

        $variants[] = trim(preg_replace('/\s*\(.*?\)\s*/', ' ', $title));
        $variants[] = preg_replace('/[^\p{L}\p{N}\s]/u', '', $title);

        $words = preg_split('/\s+/', $title);
        if (count($words) > 4) {
            $variants[] = implode(' ', array_slice($words, 0, 4));
        }

        $variants = array_map(function ($v) {
            return trim(preg_replace('/\s+/', ' ', $v));
        }, $variants);

        $variants = array_values(array_unique(array_filter($variants)));

        return $variants;
    }

    private function extractImageFromResults(array $results): ?string
    {
        foreach ($results as $r) {
            if (!empty($r['background_image'])) {
                return $r['background_image'];
            }
            if (!empty($r['background_image_additional'])) {
                return $r['background_image_additional'];
            }
        }
        return null;
    }

    private function getExtensionFromResponse($response): ?string
    {
        $contentType = $response->header('Content-Type');
        if (!$contentType) {
            return null;
        }

        if (Str::contains($contentType, 'jpeg') || Str::contains($contentType, 'jpg')) {
            return 'jpg';
        }
        if (Str::contains($contentType, 'png')) {
            return 'png';
        }
        if (Str::contains($contentType, 'webp')) {
            return 'webp';
        }
        return null;
    }

    private function logMissingCover(string $title): void
    {
        $logLine = '[' . now()->toDateTimeString() . '] ' . $title . PHP_EOL;
        file_put_contents(storage_path('logs/missing_covers.log'), $logLine, FILE_APPEND | LOCK_EX);
    }
}
