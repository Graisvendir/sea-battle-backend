<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/start",
     *     tags={"Game"},
     *     summary="Начало новой игры",
     *     @OA\Response(
     *         response="200",
     *         description="Старт игры",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 title="Игра успешно создана",
     *                 type="boolean"
     *             ),
     *             @OA\Property(
     *                 property="id",
     *                 title="ID игры",
     *                 type="integer",
     *             ),
     *             @OA\Property(
     *                 property="code",
     *                 title="Код игрока",
     *                 type="string",
     *             ),
     *             @OA\Property(
     *                 property="invite",
     *                 title="Код для приглашения",
     *                 type="string"
     *             ),
     *         )
     *     )
     * )
     */
    public function start(GameService $gameService): JsonResponse
    {
        $game = $gameService->create();

        return response()->apiSuccess([
            'id' => $game->id,
            'code' => $game->creator->code,
            'invite' => $game->invited->code,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/ready/{id}/{code}",
     *     tags={"Game"},
     *     summary="Готовность к бою игрока",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID игры",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Код игрока",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="",
     *         @OA\Schema(
     *             type="object"
     *         )
     *     )
     * )
     */
    public function ready(): JsonResponse
    {

        return new JsonResponse([
            'success' => true
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/shot/{id}/{code}",
     *     tags={"Game"},
     *     summary="Сделать выстрел",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID игры",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Код игрока",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="",
     *         @OA\Schema(
     *             type="object"
     *         )
     *     )
     * )
     */
    public function shot(): JsonResponse
    {

        return new JsonResponse([
            'success' => true
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/status/{id}/{code}",
     *     tags={"Game"},
     *     summary="Статус игры либо полный, либо в сокращенном виде",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID игры",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Код игрока",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="short",
     *         in="query",
     *         required=false,
     *         description="Вернуть краткую статистику, без статуса полей",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Статус игры с общей информацией об игре, своими полями и полями противника",
     *         @OA\JsonContent(
     *             title="Статус игры",
     *             @OA\Property(
     *                 property="game",
     *                 title="Общая информация об игре",
     *                 @OA\Property(
     *                     property="id",
     *                     title="ID игры",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     title="Статус игры",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="invite",
     *                     title="Код для приглашения",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="myTurn",
     *                     title="Мой ход?",
     *                     type="boolean"
     *                 ),
     *                 @OA\Property(
     *                     property="meReady",
     *                     title="Игрок готов к началу игры",
     *                     type="boolean"
     *                 ),
     *             ),
     *             @OA\Property(
     *                 property="fieldMy",
     *                 title="Мое поле",
     *                 type="array",
     *                 @OA\Items(
     *                     type="array",
     *                     @OA\Items(
     *                         type="array",
     *                         maxItems=2,
     *                         @OA\Items(
     *                             type="string",
     *                         )
     *                     )
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="fieldEnemy",
     *                 title="Поля противника",
     *                 type="array",
     *                 @OA\Items(
     *                     type="array",
     *                     @OA\Items(
     *                         type="array",
     *                         maxItems=2,
     *                         @OA\Items(
     *                             type="string",
     *                         )
     *                     )
     *                 )
     *             ),
     *         )
     *     )
     * )
     */
    public function status(GameService $gameService): JsonResponse
    {
        return response()->apiSuccess(GameResource::make($gameService->getCurrent()));
    }
}
