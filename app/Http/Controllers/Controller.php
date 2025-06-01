<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="Документация к API"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="ApiKeyAuth",
 *      type="apiKey",
 *      in="header",
 *      name="X-API-Key"
 *  )
 */
abstract class Controller
{
    //
}
