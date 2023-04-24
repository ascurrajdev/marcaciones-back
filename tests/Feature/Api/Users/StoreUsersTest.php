<?php

namespace Tests\Feature\Api\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_store_a_user_with_permissions(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['users-store']);
        $response = $this->postJson(route('api.users.store'),[
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => null,
            'department_id' => null,
        ]);
        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function cannot_store_a_user_without_permissions(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,[]);
        $response = $this->postJson(route('api.users.store'),[
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => null,
            'department_id' => null,
        ]);
        $response->assertForbidden();
    }
}
