<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // https://laravel.com/docs/9.x/responses#response-macros
        // Теперь можно пользоваться response()->apiSuccess([]) в контроллерах
        Response::macro('apiSuccess', function (array $jsonData = []) {
            $jsonData['success'] = true;

            return Response::json($jsonData);
        });

        // Теперь можно пользоваться response()->apiError([]) в контроллерах
        Response::macro('apiError', function (array $error, $httpCode = 400) {
            $response = array_merge(['success' => false], $error);

            return Response::json($response, $httpCode);
        });
    }
}
