<?php

namespace Tests\Feature\OnDB;

use App\Models\Game;
use App\Models\Ship;
use App\Rules\Ships\ShipOutOfRange;
use App\Services\GameService;
use Tests\TestCase;

class FieldControllerTest extends TestCase
{
    protected Game|null $game = null;

    public function setUp(): void
    {
        // без этого потяреюятся куча стартовых классов в сервис контейнере (например роутинг отвалится)
        // инфа отсюда https://laravel.com/docs/8.x/testing#creating-tests
        parent::setUp();

        // создаем игру, в которой будут прогоняться все автотесты
        /** @var GameService $gameService */
        $gameService = $this->app->make(GameService::class);
        $this->game = $gameService->create();
    }

    /**
     * @dataProvider successDataProvider
     *
     * @param $ships
     * @return void
     */
    public function testPlaceShipCorrect($ships): void
    {
        $url = route('api.place-ships', ['id' => $this->game->id, 'code' => $this->game->creator->code]);

        $response = $this->postJson($url, $ships);

        $responseJson = $response->json();

        $response->assertStatus(200);
        $this->assertTrue($responseJson['success']);
        $this->assertArrayNotHasKey('error', $responseJson);
    }

    /**
     * @dataProvider shipOutOfRangeDataProvider
     *
     * @param $ships
     * @return void
     */
    public function testPlaceShipOutOfRange($ships): void
    {
        $url = route('api.place-ships', ['id' => $this->game->id, 'code' => $this->game->creator->code]);

        $response = $this->postJson($url, $ships);

        $responseJson = $response->json();

        $response->assertStatus(422);
        $this->assertFalse($responseJson['success']);
        $this->assertArrayHasKey('error', $responseJson);
        $this->assertArrayHasKey('message', $responseJson);

        $this->assertArrayHasKey(ShipOutOfRange::class, $responseJson['failedRules'][0]);
    }

    public function successDataProvider(): array
    {
        return [
            'correct ship list' => $this->getCorrectShipList(),
            'correct ship list' => [
                [
                    [
                        'id' => 1,
                        'x' => 5,
                        'y' => 5,
                        'length' => 2,
                        'orientation' => Ship::HORIZONTAL_ORIENTATION,
                    ],
                ]
            ],
        ];
    }

    protected function getCorrectShipList(): array
    {
        return [
            [
                [
                    'x' => 5,
                    'y' => 5,
                    'length' => 2,
                    'orientation' => Ship::HORIZONTAL_ORIENTATION,
                ],
                [
                    'x' => 0,
                    'y' => 0,
                    'length' => 2,
                    'orientation' => Ship::HORIZONTAL_ORIENTATION,
                ],
                [
                    'x' => 9,
                    'y' => 0,
                    'length' => 3,
                    'orientation' => Ship::VERTICAL_ORIENTATION,
                ],
                [
                    'x' => 9,
                    'y' => 9,
                    'length' => 1,
                    'orientation' => Ship::VERTICAL_ORIENTATION,
                ],
                [
                    'x' => 0,
                    'y' => 9,
                    'length' => 4,
                    'orientation' => Ship::HORIZONTAL_ORIENTATION,
                ],
            ]
        ];
    }

    public function shipOutOfRangeDataProvider(): array
    {
        return [
            'ship out of range 1' => [
                [
                    [
                        'x' => 9,
                        'y' => 1,
                        'length' => 2,
                        'orientation' => Ship::HORIZONTAL_ORIENTATION,
                    ],
                ],
            ],
            'ship out of range 2' => [
                [
                    [
                        'x' => 1,
                        'y' => 9,
                        'length' => 2,
                        'orientation' => Ship::VERTICAL_ORIENTATION,
                    ],
                ],
            ],
            'ship out of range 3' => [
                [
                    [
                        'x' => 9,
                        'y' => 9,
                        'length' => 2,
                        'orientation' => Ship::HORIZONTAL_ORIENTATION,
                    ],
                ],
            ],
            'ship out of range 4' => [
                [
                    [
                        'x' => 9,
                        'y' => 5000,
                        'length' => 2,
                        'orientation' => Ship::HORIZONTAL_ORIENTATION,
                    ],
                ],
            ],

        ];
    }
}
