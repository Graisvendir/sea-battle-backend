<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameStatus;
use App\Models\User;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class GameService
 * @package App\Services
 */
class GameService
{

    const CREATE_ERROR = [
        'httpCode' => '400',
        'errorCode' => 'CREATE_ERROR',
        'message' => 'Не удалось создать игру',
    ];

    const UNEXPECTED_ERROR = [
        'httpCode' => '400',
        'errorCode' => 'UNEXPECTED_ERROR',
        'message' => 'Непредвиденная ошибка',
    ];


    /**
     * Создание новой игры с созданием пользователей
     *
     * @return Game|null
     */
    public function create(): ?Game
    {
        try {
            $creator = User::createWithCode();
            $invited = User::createWithCode();

            $game = new Game();
            $game->creator_id = $creator->id;
            $game->player_turn_id = $creator->id;
            $game->invited_id = $invited->id;

            $status = GameStatus::whereCode('placement')->first();

            if (!$status) {
                return null;
            }

            $game->status_id = $status->id;

            $game->saveOrFail();

            return $game;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function status(): array
    {
        $data = $this->short();

        if (!request()->get('short')) {
            $data = array_merge($data, $this->full());
        }

        return $data;
    }

    #[ArrayShape([
        'game' => "array"
    ])]
    public function short(): array
    {
        return [
            'game' => [
                'id' => 9,
                'status' => 1,
                'invite' => 'gerwhwqet',
                'myTurn' => false,
                'meReady' => true,
            ],
        ];
    }

    #[ArrayShape([
        'fieldMy' => "\string[][]",
        'fieldEnemy' => "array"
    ])]
    public function full(): array
    {
        return [
            'fieldMy' => [
                ['hidden'],
            ],
            'fieldEnemy' => [],
        ];
    }
}
