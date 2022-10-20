<?php

namespace App\Exceptions\Ship;

use App\Exceptions\BaseException;

class ShipsIntersectsException extends BaseException
{
    protected $message = 'Ships is intersects';
    protected $code = '10';
}
