<?php

namespace Tests\Feature\Api\Marcacion;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Marcacion;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_list_all_marcaciones_with_a_user_authenticated(): void
    {
        $user = User::factory()->create();
        Marcacion::factory()->for($user)->count(10)->create();
        Sanctum::actingAs($user,["*"]);
        $response = $this->getJson(route("api.marcaciones.index"));
        $response->assertSuccessful();
        $response->assertJsonCount(10,"data");
    }
    /**
     * @test
     */
    public function cannot_list_all_marcaciones_with_a_user_guest(): void
    {
        $response = $this->getJson(route("api.marcaciones.index"));
        $response->assertUnauthorized();
    }
}
