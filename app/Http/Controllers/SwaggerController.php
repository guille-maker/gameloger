<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="GameLoger API",
 *     version="1.0",
 *     description="Documentación de la API de GameLoger"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local"
 * )
 */
class SwaggerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     summary="Ruta de prueba para Swagger",
     *     tags={"Test"},
     *     @OA\Response(
     *         response=200,
     *         description="Respuesta exitosa"
     *     )
     * )
     */
    public function test()
    {
        return response()->json(['message' => 'Swagger funciona']);
    }
}
