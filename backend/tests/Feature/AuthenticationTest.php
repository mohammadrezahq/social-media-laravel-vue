<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $data = [
            'username' => $user->username,
            'password' => '1234',
        ];

        $response = $this->post('/api/u/login', $data);

        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $user = [
            'username'=> 'TestUserName',
            'display_name'=> 'My test name',
            'email'=> 'test@test.com',
            'password'=> 'passwordpassword',
            'gender'=> 'male',
            'birthday'=> '2005-12-30',
            'bio'=> 'this is bio',
        ];

        $response = $this->postJson('/api/u/register', $user);

        $this->assertAuthenticated();
        $response->assertStatus(201);
    }
}
