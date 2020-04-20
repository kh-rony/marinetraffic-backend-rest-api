<?php

namespace Tests\Feature;

use Tests\TestCase;

class TestVesselAPI extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetVessels()
    {
        $response = $this->withHeaders(['Content-Type' => 'application/json',])
            ->json('GET', '/vessels/json');

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'success']);
    }
}
