<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function registration_requires_fields()
    {
        $response = $this->post('/api/register', []);

        $response->assertStatus(422);
    }

    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function a_user_can_be_register_and_auth_token_is_returned_after_registration()
    {
        $response = $this->post('/api/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token', 'token_type', 'expires_in'
        ]);
    }
}
