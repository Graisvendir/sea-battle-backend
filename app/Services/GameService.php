<?php

namespace App\Services;

use App\Exceptions\Game\NotFoundPlacementStatusException;
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
    /**
     * Создание новой игры с созданием пользователей
     *
     * @return Game|null
     * @throws NotFoundPlacementStatusException
     * @throws \Throwable
     */
    public function create(): ?Game
    {
        $creator = User::createWithCode();
        $invited = User::createWithCode();

        $game = new Game();
        $game->creator_id = $creator->id;
        $game->player_turn_id = $creator->id;
        $game->invited_id = $invited->id;

        $status = GameStatus::whereCode('placement')->first();

        if (!$status) {
            throw new NotFoundPlacementStatusException();
        }

        $game->status_id = $status->id;

        $game->saveOrFail();

        return $game;
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
