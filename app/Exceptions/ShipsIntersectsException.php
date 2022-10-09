<?php

namespace App\Exceptions;

use Exception;

class ShipsIntersectsException extends PlannedException {

    protected $message = 'Ships is intersects';
    protected $code    = '10';

}
