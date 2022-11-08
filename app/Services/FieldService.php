<?php

namespace App\Services;

use App\Exceptions\Ship\ShipsIntersectsException;
use App\Models\DTO\Ships\PlaceShipDTO;
use App\Models\DTO\Ships\ShipDTO;
use App\Models\GameShip;
use App\Models\Ship;
use Illuminate\Support\Collection;
use Exception;

/**
 * Класс управления полем
 */
class FieldService
{
    /**
     * @var Collection|GameShip[]
     */
    protected Collection $gameShipsById;

    public function __construct(protected GameService $gameService)
    {
        $this->gameShipsById = $this->gameService->getCurrent()->ships->keyBy('id');
    }

    /**
     * Размещение/перемещение кораблей
     *
     * @throws ShipsIntersectsException
     * @throws Exception
     * @throws \Throwable
     */
    public function placeShips(PlaceShipDTO $placeShipDTO): void
    {
        $postShips = $placeShipDTO->getShips();

        foreach ($postShips as $postShip) {
            $this->placeShip($postShip);
        }
    }

    public function placeShip(ShipDTO $gameShipDTO): void
    {
        if ($gameShipDTO->getId()) {
            // значит, уже существующий корабль двигают. Подставляем данные в уже существующий корабль
            /** @var GameShip $existShip */
            $existShip = $this->gameShipsById->get($gameShipDTO->getId());

            $existShip->x = $gameShipDTO->getX();
            $existShip->y = $gameShipDTO->getY();
            $existShip->orientation = $gameShipDTO->getOrientation();

            if ($existShip->isDirty()) {
                $existShip->saveOrFail();
            }

            return;
        }

        $newShip = GameShip::make($gameShipDTO);
        $newShip->game_id = $this->gameService->getCurrent()->id;
        $newShip->user_id = $this->gameService->getCurrent()->id;
        $newShip->saveOrFail();

        $this->gameShipsById->push($newShip);
    }

    public function getCurrentFieldMatrix(): array
    {
        $matrix = [];

        foreach ($this->gameShipsById as $ship) {
            // +1 чтобы не выйти за границы массива при заполнении соседни клеток корабля
            $x = $ship->x + 1;
            $y = $ship->y + 1;

            // чтобы заполнить клетки спереди и сзади от корабля
            $length = $ship->getLength() + 1;

            $orientation = $ship->orientation;

            if ($orientation === Ship::HORIZONTAL_ORIENTATION) {
                for ($i = $x - 1; $i < $x + $length; $i++) {
                    $matrix[$y - 1][$i] = 1;
                    $matrix[$y]    [$i] = 1;
                    $matrix[$y + 1][$i] = 1;
                }
            } elseif ($orientation === Ship::VERTICAL_ORIENTATION) {
                for ($i = $y - 1; $i < $y + $length; $i++) {
                    $matrix[$i][$x - 1] = 1;
                    $matrix[$i][$x] = 1;
                    $matrix[$i][$x + 1] = 1;
                }
            }
        }

        return $matrix;
    }
}
