<?php

namespace Tests\Feature\Mock;

use App\Exceptions\Handler;
use App\Models\Game;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Testing\Fluent\AssertableJson;
use Mockery;
use Tests\TestCase;


class GameControllerTest extends TestCase
{

    public function testStartSuccess()
    {
        $creator = new User(['id' => 1]);
        $invited = new User(['id' => 2]);
        $game = new Game(['id' => 1]);

        $game->setAttribute('creator', $creator);
        $game->setAttribute('invited', $invited);

        /** @var Mockery\MockInterface $gameService */
        $gameService = Mockery::mock(GameService::class);
        $gameService->shouldReceive('create')->andReturn($game);

        $this->app->instance(GameService::class, $gameService);

        $url = route('api.start');
        $response = $this->postJson($url);
        $responseJson = $response->json();

        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->hasAll(['id', 'code', 'invite'])
                ->etc()
        );
    }

    public function testStartError()
    {
        /** @var Mockery\MockInterface $gameService */
        $gameService = Mockery::mock(GameService::class);
        $gameService->shouldReceive('create')->andReturn(null);

        $this->app->instance(GameService::class, $gameService);

        $url = route('api.start');
        $response = $this->postJson($url);

        $response->assertStatus(400);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->hasAll([Handler::ERROR_CODE_KEY, Handler::MESSAGE_KEY])
                ->etc()
        );
    }
}
