<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Con;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('start', [Con\GameController::class, 'start'])->name('start');

Route::middleware('auth:api')->group(function () {
    Route::get(   'status/{id}/{code}',       [Con\GameController::class,  'status'])     ->name('status');
    Route::post(  'place-ships/{id}/{code}',  [Con\FieldController::class, 'placeShips']) ->name('place-ships');
    Route::delete('clear-field/{id}/{code}',  [Con\FieldController::class, 'clearField']) ->name('clear-field');
    Route::post(  'ready/{id}/{code}',        [Con\GameController::class,  'ready'])      ->name('ready');
    Route::post(  'shot/{id}/{code}',         [Con\GameController::class,  'shot'])       ->name('shot');

    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get( 'load/{id}/{code}', [Con\ChatController::class, 'load'])->name('load');
        Route::post('send/{id}/{code}', [Con\ChatController::class, 'send'])->name('send');
    });
});
