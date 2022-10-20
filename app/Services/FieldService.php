<?php

namespace App\Services;

use App\Exceptions\Ship\ShipLengthNotFoundException;
use App\Exceptions\Ship\ShipsIntersectsException;
use App\Models\DTO\Ships\PlaceShipDTO;
use App\Models\DTO\Ships\ShipDTO;
use App\Models\Game;
use App\Models\GameShip;
use App\Models\Ship;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Exception;

/**
 * Класс управления полем
 */
class FieldService
{

    protected Game $game;

    /**
     * @var Collection|GameShip[]
     */
    protected Collection $ships;

    public function __construct(Request $request)
    {
        $this->game = $request->user()->game();
        $this->ships = $this->game->ships->collect();
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

        $existShipsById = $this->ships->keyBy('id');

        foreach ($postShips as $postShip) {
            if ($postShip->getId()) {
                // значит, уже существующий корабль двигают. Подставляем данные в уже существующий корабль
                /** @var GameShip $existShip */
                $existShip = $existShipsById->get($postShip->getId());

                $existShip->x = $postShip->getX();
                $existShip->y = $postShip->getY();
                $existShip->orientation = $postShip->getOrientation();

                if ($existShip->isDirty()) {
                    $existShip->saveOrFail();
                }

                continue;
            }

            $existShip = GameShip::make($postShip);
            $existShip->saveOrFail();

            $this->ships->push($existShip);
        }
    }

    public function getCurrentFieldMatrix(): array
    {
        $matrix = [];

        foreach ($this->ships as $ship) {
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
