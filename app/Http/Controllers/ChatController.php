<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Game;
use App\Models\GameMessage;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/chat/load/{id}/{code}",
     *     tags={"Chat"},
     *     summary="Загрузить список сообщений чата после указанного timestamp",
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
     *     @OA\Parameter(
     *         name="lastTime",
     *         in="query",
     *         required=false,
     *         description="начиная с какого времени загружать сообщения. Unix-timestamp",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список сообщений начиная с указанного timestamp"
     *     )
     * )
     */
    public function load(Request $request, GameMessage $messageModel): JsonResponse
    {
        $lastTime = (int) $request->input('lastTime', 0);

        /** @var Game $game */
        $game = $request->user()->game();

        $messages = $messageModel->loadByLastTime($lastTime, $game->id)->get()->all();

        return response()->apiSuccess([
            'messages' => MessageResource::collection($messages)->toArray($request),
            'lastTime' => time()
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/chat/send/{id}/{code}",
     *     tags={"Chat"},
     *     summary="Отправить сообщение в чат",
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
     *     @OA\Parameter(
     *         name="message",
     *         in="query",
     *         required=true,
     *         description="Передаваемое сообщение",
     *         @OA\Schema(
     *             type="string",
     *             maxLength=250
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Сообщение отправлено успешно"
     *     )
     * )
     */
    public function send(MessageRequest $request, GameMessage $messageModel, GameService $gameService): JsonResponse
    {
        $messageDto = $request->validatedObject();

        try {
            /** @var User $user */
            $user = $request->user();

            $messageModel->message = $messageDto->getMessage();
            $messageModel->user_id = $user->id;
            $messageModel->game_id = $user->game()->id;

            $messageModel->saveOrFail();
        } catch (\Throwable $e) {
            return response()->apiError($gameService::UNEXPECTED_ERROR);
        }

        return response()->apiSuccess([]);
    }
}
