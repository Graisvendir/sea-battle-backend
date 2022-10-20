<?php

namespace Tests\Unit\Rule;

use App\Models\Ship;
use App\Rules\Ships\ShipsIntersectsRule;
use PHPUnit\Framework\TestCase;

class ShipIntersectsRuleTest extends TestCase
{
    /**
     * @dataProvider successDataProvider
     *
     * @return void
     */
    public function testSuccess(array $matrix, array $ships): void
    {
        $shipsIntersectsRule = new ShipsIntersectsRule($matrix);
        $success = $shipsIntersectsRule->passes('', $ships);

        $this->assertTrue($success);
    }

    /**
     * @dataProvider errorDataProvider
     *
     * @return void
     */
    public function testError(array $matrix, array $ships)
    {
        $shipsIntersectsRule = new ShipsIntersectsRule($matrix);
        $success = $shipsIntersectsRule->passes('', $ships);

        $this->assertFalse($success);
    }

    public function successDataProvider(): array
    {
        return [
            'simple' => [
                [
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                ],
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

    public function errorDataProvider(): array
    {
        return [
            'simple' => [
                [
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 1, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                    [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ],
                ],
                [
                    [
                        'id' => 1,
                        'x' => 1,
                        'y' => 1,
                        'length' => 2,
                        'orientation' => Ship::HORIZONTAL_ORIENTATION,
                    ],
                ]
            ],
        ];
    }
}
