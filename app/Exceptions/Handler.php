<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    public const ERROR_CODE_KEY       = 'errorCode';
    public const MESSAGE_KEY          = 'message';
    public const EXCEPTION_DATA_KEY   = 'exceptionData';
    public const VALIDATOR_ERRORS_KEY = 'errors';

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // Обработка всех BaseException внутри лары. Всегда приводит его в json и отдает как ошибку ниже 500 кода
        $this->renderable(function (BaseException $e, Request $request) {
            $data = [
                static::ERROR_CODE_KEY => $e->getCode(),
                static::MESSAGE_KEY    => $e->getMessage(),
            ];

            if ($e->getExceptionData()) {
                $data[static::EXCEPTION_DATA_KEY] = $e->getExceptionData();
            }

            return response()->apiError($data, $e->getHttpCode());
        });

        // Отдельно обрабатываем ValidationException, т.к. список сообщений об ошибках достается другим методом
        $this->renderable(function (ValidationException $e, Request $request) {
            $data = [
                static::ERROR_CODE_KEY        => $e->getCode(),
                static::MESSAGE_KEY           => $e->errors(),
                static::VALIDATOR_ERRORS_KEY  => $e->validator->failed(),
            ];

            return response()->apiError($data, 422);
        });

        // Обработка всех Exception внутри лары. Всегда приводит его в json и отдает как ошибку 500 и выше
        $this->renderable(function (Exception $e, Request $request) {
            $data = [
                static::ERROR_CODE_KEY => $e->getCode(),
                static::MESSAGE_KEY    => $e->getMessage(),
            ];

            // в тестовом окружении добавляем названия правил валидации, на которых упал код
            if ($this->isTestEnv()) {
                $data['errorClass'] = $e::class;
                $data['errorPosition'] = $e->getFile() . '   ' . $e->getLine();
                $data['trace'] = $e->getTraceAsString();
            }

            return response()->apiError($data);
        });
    }

    public function isTestEnv(): bool
    {
        return env('APP_ENV') === 'testing';
    }
}
