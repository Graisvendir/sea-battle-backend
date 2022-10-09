<?php

namespace App\Exceptions;

use Exception;

/**
 * PlannedException class
 *
 * Все ожидаемые ошибки будут возвращены пользователю
 */
class PlannedException extends Exception {

    protected int $httpCode = 422;

    public function getHttpCode(): int {
        return $this->httpCode;
    }

}
