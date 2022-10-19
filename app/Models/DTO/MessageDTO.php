<?php

namespace App\Models\DTO;

class MessageDTO implements DTOInterface
{
    protected string $message = '';

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
