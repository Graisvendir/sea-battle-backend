<?php

namespace App\Exceptions\Game;

use App\Exceptions\BaseException;

class NotFoundPlacementStatusException extends BaseException
{
    protected $message = 'Not found "placement" status';
    protected $code = '100';
}
