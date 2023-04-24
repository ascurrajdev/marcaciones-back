<?php

namespace Tests\Feature\Api\Users;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListAllUsersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_users_with_a_user_authenticated(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,['users-index']);
        $response = $this->getJson(route('api.users.index'));
        $response->assertSuccessful();
    }
    /**
     * @test
     */
    public function cannot_list_all_users_with_a_user_authenticated_without_authorization(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user,[]);
        $response = $this->getJson(route('api.users.index'));
        $response->assertForbidden();
    }
}
