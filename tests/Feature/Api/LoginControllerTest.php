<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_login_a_user(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('api.login'),[
            "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function cannot_login_a_user_with_a_email_not_exists(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('api.login'),[
            "email" => "example@example.org",
            "password" => "password"
        ]);
        $response->assertInvalid("email");
    }
    /**
     * @test
     */
    public function cannot_login_a_user_with_a_password_invalid(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('api.login'),[
            "email" => $user->email,
            "password" => "password1"
        ]);
        $response->assertInvalid("email");
    }
}
