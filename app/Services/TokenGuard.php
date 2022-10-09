<?php

namespace App\Services;

use Illuminate\Auth\TokenGuard as BaseTokenGuard;
use Illuminate\Support\Facades\Route;

class TokenGuard extends BaseTokenGuard {

    /**
     * Родительский метод берет значение для авторизации только из GET и POST параметров
     * Этот метод берет еще и из параметров роута
     *
     * @return string
     */
    public function getTokenForRequest(): string {
        $token = parent::getTokenForRequest();

        if (empty($token)) {
            $token = Route::current()->parameter($this->inputKey, '');
        }

        return $token;
    }
}
