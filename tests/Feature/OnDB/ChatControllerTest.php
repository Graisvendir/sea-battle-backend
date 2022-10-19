<?php

namespace Tests\Feature\OnDB;

use App\Models\Game;
use App\Services\GameService;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    protected const CHAT_MESSAGE = 'test message';

    protected Game|null $game = null;

    public function setUp(): void
    {
        parent::setUp();

        // создаем игру, в которой будут прогоняться все автотесты
        /** @var GameService $gameService */
        $gameService = $this->app->make(GameService::class);
        $this->game = $gameService->create();
    }

    public function testSendSuccess(): void
    {
        $response = $this->sendMessage();

        $responseJson = $response->json();

        $response->assertStatus(200);

        $this->assertTrue($responseJson['success']);
    }

    public function testLoadSuccess(): void
    {
        $this->sendMessage();

        $url = route('api.chat.load', ['id' => $this->game->id, 'code' => $this->game->creator->code]);

        $response = $this->getJson($url);
        $responseJson = $response->json();

        $response->assertStatus(200);

        $this->assertTrue($responseJson['success']);
        $this->assertIsNumeric($responseJson['lastTime']);
        $this->assertNotEmpty($responseJson['messages']);

        $firstMessage = $responseJson['messages'][0];

        $this->assertArrayHasKey('my', $firstMessage);
        $this->assertArrayHasKey('time', $firstMessage);
        $this->assertArrayHasKey('message', $firstMessage);

        $this->assertEquals(static::CHAT_MESSAGE, $firstMessage['message']);
    }

    protected function sendMessage(): TestResponse
    {
        $url = route('api.chat.send', ['id' => $this->game->id, 'code' => $this->game->creator->code]);

        return $this->postJson($url, ['message' => 'test message']);
    }
}
