<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceShipsRequest;
use App\Services\FieldService;
use Illuminate\Http\JsonResponse;

class FieldController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/place-ships/{id}/{code}",
     *     tags={"Ship"},
     *     summary="Расстановка одного или пачки кораблей на поле",
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
     *
     *     @OA\RequestBody(
     *         description="Список размещаемых кораблей в формате json",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="ships",
     *                     description="Список кораблей",
     *                     type="array",
         *     @OA\Items(
         *                     type="object",
         *                     @OA\Property(
         *                         property="x",
         *                         description="Позиция по горизонтали",
         *                         type="integer"
         *                     ),
         *                     @OA\Property(
         *                         property="y",
         *                         description="Позиция по вертикали",
         *                         type="integer"
         *                     ),
         *                     @OA\Property(
         *                         property="id",
     *                         description="<Номер корабля>",
     *                         type="integer",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="length",
     *                         description="<Длина корабля>",
     *                         type="integer",
     *                         example="2"
     *                     ),
     *                     @OA\Property(
     *                         property="orientation",
     *                         description="Ориентация корабля на поле (vertical|horizontal)",
     *                         type="string",
     *                         example="horizontal"
     *                     ),
     *                 )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Корабль(и) устанавились"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Не удалось установить корабль(и)"
     *     ),
     * )
     * @throws \App\Exceptions\Ship\ShipsIntersectsException
     */
    public function placeShips(PlaceShipsRequest $request, FieldService $fieldService): JsonResponse
    {
        $validated = $request->validatedDTO();

        $fieldService->placeShips($validated);

        return response()->apiSuccess();
    }

    /**
     * @OA\Delete(
     *     path="/api/clear-field/{id}/{code}",
     *     tags={"Ship"},
     *     summary="Очистка поля от всех кораблей",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID игры",
     *     ),
     *     @OA\Parameter(
     *         name="code",
     *         in="path",
     *         required=true,
     *         description="Код игрока",
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Очистка поля от кораблей"
     *     )
     * )
     */
    public function clearField(): JsonResponse
    {

        return new JsonResponse([
            'success' => true
        ]);
    }
}
