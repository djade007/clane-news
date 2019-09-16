<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function login_requires_email_and_password()
    {
        $response = $this->post('/api/login');

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function user_can_login_and_auth_token_is_returned_after_registration()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'access_token', 'token_type', 'expires_in'
        ]);
    }
}
