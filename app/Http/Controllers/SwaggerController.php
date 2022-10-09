<?php

namespace App\Http\Controllers;

use OpenApi\Generator;
use Illuminate\Http\JsonResponse;

class SwaggerController extends Controller {

    /**
     * @OA\Info(
     *     title="Сибирикс. API для игры Морской бой",
     *     version="1.0",
     * )
     */

    public function index() {
        return view('swagger');
    }

    public function json(): JsonResponse {
        $openapi = Generator::scan(['../app/Http']);

        return response()->json($openapi->jsonSerialize());
    }
}
