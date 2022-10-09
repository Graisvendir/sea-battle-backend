<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use \Closure;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    const UNAUTHORIZED = [
        'httpCode' => 401,
        'errorCode' => 'Unauthorized',
        'message' => 'Авторизуйся, бро!',
    ];

    /**
     * Получает пользователя
     * Проверяет авторизованность пользователя
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        if (!$request->user()) {
            return response()->apiError($this::UNAUTHORIZED);
        }

        return $next($request);
    }

    /**
     * Заглушил, чтобы при неудачной попытке авторизации не бросал Exception и не редиректил куда-либо
     *
     * @param Request $request
     * @param array $guards
     */
    protected function unauthenticated($request, array $guards) {}
}
