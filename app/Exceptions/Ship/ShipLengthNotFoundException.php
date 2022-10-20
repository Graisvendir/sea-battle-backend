<?php

namespace App\Exceptions\Ship;

use App\Exceptions\BaseException;

class ShipLengthNotFoundException extends BaseException
{
    protected $message = 'Ship length not found';
    protected $code = '11';

    public static function make(int $shipLength)
    {
        $e = new static();

        $e->exceptionData = [
            'shipLength' => $shipLength,
        ];

        return $e;
    }
}
