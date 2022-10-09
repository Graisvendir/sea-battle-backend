<?php

namespace App\Providers;

use App\Services\TokenGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Ну типо авторизация
        // при получении запроса берет указанный в нем код, ищет в БД
        // если нашел - все хорошо, пользователь авторизован, иначе отдает ошибку не заходя в экшн
        // теперь юзер доступен через app()->user()
        Auth::extend('token', function ($app, $name, array $config) {
            return new TokenGuard(
                Auth::createUserProvider($config['provider']),
                request(),
                'code',
                'code'
            );
        });
    }
}
