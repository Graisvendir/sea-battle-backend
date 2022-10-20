<?php

namespace App\Exceptions;

use Exception;

/**
 * PlannedException class
 *
 * Все ожидаемые ошибки будут возвращены пользователю
 */
class BaseException extends Exception
{
    protected int $httpCode = 422;
    protected array $exceptionData = [];

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getExceptionData(): array
    {
        return $this->exceptionData;
    }
}
