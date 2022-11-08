<?php

namespace App\Models\DTO;

use Illuminate\Support\Collection;

class FieldDTO
{
    public function __construct(protected Collection $ships, protected Collection $shots)
    {
    }

    public static function make(Collection $ships, Collection $shots)
    {
        return new static($ships, $shots);
    }

    /**
     * @return Collection
     */
    public function getShips(): Collection
    {
        return $this->ships;
    }

    /**
     * @return Collection
     */
    public function getShots(): Collection
    {
        return $this->shots;
    }
}
