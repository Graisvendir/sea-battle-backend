<?php

namespace Tests\Feature\Mock;

use App\Models\Game;
use App\Models\User;
use App\Services\GameService;
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

        $this->assertTrue($responseJson['success']);
        $this->assertArrayNotHasKey('httpCode', $responseJson);
        $this->assertArrayHasKey('id', $responseJson);
        $this->assertArrayHasKey('code', $responseJson);
        $this->assertArrayHasKey('invite', $responseJson);
    }

    public function testStartError()
    {
        /** @var Mockery\MockInterface $gameService */
        $gameService = Mockery::mock(GameService::class);
        $gameService->shouldReceive('create')->andReturn(null);

        $this->app->instance(GameService::class, $gameService);

        $url = route('api.start');
        $response = $this->postJson($url);
        $responseJson = $response->json();

        $response->assertStatus(400);

        $this->assertFalse($responseJson['success']);

        $this->assertArrayHasKey('httpCode', $responseJson);
        $this->assertArrayHasKey('errorCode', $responseJson);
        $this->assertArrayHasKey('message', $responseJson);
    }
}
