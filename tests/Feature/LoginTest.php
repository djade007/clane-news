<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
