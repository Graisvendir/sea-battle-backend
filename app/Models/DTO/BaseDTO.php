<?php

namespace App\Models\DTO;

abstract class BaseDTO implements DTOInterface
{
    protected int $id = 0;

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
