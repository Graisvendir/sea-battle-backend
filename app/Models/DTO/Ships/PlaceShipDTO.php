<?php

namespace App\Models\DTO\Ships;

use App\Models\DTO\DTOInterface;

class PlaceShipDTO implements DTOInterface
{
    protected array $ships = [];

    public function __construct(array $data = [])
    {
        $ships = $data['ships'] ?? [];
        $shipObjects = [];

        foreach ($ships as $ship) {
            $shipObjects[] = new ShipDTO($ship);
        }

        $this->ships = $shipObjects;
    }

    /**
     * @return ShipDTO[]
     */
    public function getShips(): array
    {
        return $this->ships;
    }
}
