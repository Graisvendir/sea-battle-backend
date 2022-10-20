<?php

namespace Tests\Feature\OnDB;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    public function testStartSuccess()
    {
        $url = route('api.start');
        $response = $this->postJson($url);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', true)
                ->hasAll(['id', 'code', 'invite'])
                ->etc()
        );
    }

    public function testInvalidStart()
    {
        $url = route('api.start');
        $response = $this->getJson($url);

        $response->assertStatus(400);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('success', false)
                ->etc()
        );
    }
}
