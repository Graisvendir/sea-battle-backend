<?php

namespace App\Models\DTO\Ships;

use App\Models\DTO\DTOInterface;

class ShipDTO implements DTOInterface
{
    protected int $x = -1;
    protected int $y = -1;
    protected int $id = 0;
    protected int $lenght = -1;
    protected string $orientation = '';

    public function __construct(array $data = [])
    {
        $this->x = $data['x'] ?? -1;
        $this->y = $data['y'] ?? -1;
        $this->id = $data['id'] ?? 0;
        $this->lenght = $data['length'] ?? 0;
        $this->orientation = $data['orientation'] ?? '';
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLenght(): int
    {
        return $this->lenght;
    }

    public function getOrientation(): string
    {
        return $this->orientation;
    }
}
