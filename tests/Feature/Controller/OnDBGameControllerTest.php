<?php

namespace Tests\Feature\Controller;

use Tests\TestCase;


class OnDBGameControllerTest extends TestCase {

    public function testStartSuccess() {
        $url          = route('api.start');
        $response     = $this->postJson($url);
        $responseJson = $response->json();

        $response->assertStatus(200);

        $this->assertTrue($responseJson['success']);
        $this->assertArrayNotHasKey('httpCode', $responseJson);
        $this->assertArrayHasKey('id', $responseJson);
        $this->assertArrayHasKey('code', $responseJson);
        $this->assertArrayHasKey('invite', $responseJson);
    }
}
