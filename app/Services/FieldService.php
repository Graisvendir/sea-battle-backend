<?php

namespace App\Services;

use App\Exceptions\ShipsIntersectsException;
use App\Models\Game;
use App\Models\GameShip;
use App\Models\Ship;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Exception;

/**
 * Класс управления полем
 */
class FieldService {

    protected Game $game;

    /**
     * @var Collection|GameShip[]
     */
    protected Collection $ships;

    public function __construct(Request $request) {
        $this->game  = $request->user()->game();
        $this->ships = $this->game->ships->collect();
    }

    /**
     * Размещение/перемещение кораблей
     *
     * @throws ShipsIntersectsException
     * @throws Exception
     */
    public function placeShips(array $shipsData) {
        $this->addShips($shipsData);
        $isValid = $this->validateShip();

        if (!$isValid) {
            throw new ShipsIntersectsException();
        }

        $this->saveShips();
    }

    /**
     * @param array $shipsData
     */
    protected function addShips(array $shipsData) {
        $postShips = $this->convertToModels($shipsData);

        /** @var array $postShip */
        foreach ($postShips as $postShip) {
            /** @var GameShip $gameShip */
            $gameShip = $postShip['id']
                ? $this->ships->firstWhere('id', $postShip['id'])
                : new GameShip();

            $shipLength = Ship::getByLength($postShip['length']);

            $gameShip->x           = $postShip['x'];
            $gameShip->y           = $postShip['y'];
            $gameShip->orientation = $postShip['orientation'];
            $gameShip->setAttribute('ship', $shipLength);

            if (!$gameShip->getKey()) {
                $gameShip->id = $postShip['id'] ?? 0;

                $this->ships->push($postShip);
            }
        }
    }

    public function saveShips() {
        foreach ($this->ships as $ship) {
            if (!$ship->isDirty()) continue;

            $ship->saveOrFail();
        }
    }

    public function validateShip(): bool {
        return !$this->isIntersect($this->ships);
    }

    /**
     * Конвертируем пришедшие данные кораблей в модели, чтобы со всеми объектами работать как с классами
     *
     * @param array $shipsData
     * @return Collection
     */
    public function convertToModels(array $shipsData): Collection {
        $collection = new Collection();

        foreach ($shipsData as $shipData) {
            $shipLength = Ship::getByLength($shipData['length']);

            $gameShip = new GameShip();
            $gameShip->id          = $shipData['id'] ?? 0;
            $gameShip->x           = $shipData['x'];
            $gameShip->y           = $shipData['y'];
            $gameShip->orientation = $shipData['orientation'];

            $gameShip->setAttribute('ship', $shipLength);

            $collection->push($gameShip);
        }

        return $collection;
    }

    /**
     * Пересекаются ли корабли на поле
     *
     * @param Collection|GameShip[] $currentShips
     * @return boolean
     */
    public function isIntersect(Collection $currentShips): bool {
        $matrix = [];

        /** @var GameShip $gameShip */
        foreach ($currentShips as $gameShip) {
            // +1 чтобы не выйти за границы массива при заполнении соседни клеток корабля
            $x = $gameShip->x + 1;
            $y = $gameShip->y + 1;

            // чтобы заполнить клетки спереди и сзади от корабля
            $length = $gameShip->getLength() + 1;

            if ($gameShip->orientation === Ship::HORIZONTAL_ORIENTATION) {
                for ($i = $x - 1; $i < $x + $length; $i++) {
                    if (isset($matrix[$y - 1][$i])) return true;
                    if (isset($matrix[$y]    [$i])) return true;
                    if (isset($matrix[$y + 1][$i])) return true;

                    $matrix[$y - 1][$i] = 1;
                    $matrix[$y]    [$i] = 1;
                    $matrix[$y + 1][$i] = 1;
                }
            } else {
                for ($i = $y - 1; $i < $y + $length; $i++) {
                    if (isset($matrix[$i][$x - 1])) return true;
                    if (isset($matrix[$i][$x]    )) return true;
                    if (isset($matrix[$i][$x + 1])) return true;

                    $matrix[$i][$x - 1] = 1;
                    $matrix[$i][$x]     = 1;
                    $matrix[$i][$x + 1] = 1;
                }
            }
        }

        return false;
    }

}
