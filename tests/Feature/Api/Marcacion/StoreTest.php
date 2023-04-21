<?php

namespace Tests\Feature\Api\Marcacion;

use App\Models\Department;
use App\Models\DepartmentHour;
use App\Models\Marcacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function can_store_a_marcacion(): void
    {
        $coords = fake()->localCoordinates();
        $position = array(
            "lat" => $coords["latitude"],
            "lng" => $coords["longitude"],
        );
        $user = User::factory()->create();
        Sanctum::actingAs($user, ["*"]);
        $response = $this->postJson(route('api.marcaciones.store'),[
            "position" => $position
        ]);
        $response->assertSuccessful();
    }

    /**
     * @test
     */
    public function cannot_store_a_marcacion_without_coords(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ["*"]);
        $response = $this->postJson(route('api.marcaciones.store'));
        $response->assertInvalid("position");
    }

    /**
     * @test
     */
    public function cannot_store_a_marcacion_without_a_user_valid(): void
    {
        $response = $this->postJson(route('api.marcaciones.store'));
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function can_store_a_marcacion_with_type_in(){
        now()->setTestNow(date("Y-m-d 08:00:00"));
        $department = Department::factory()->create();
        DepartmentHour::factory()
        ->for($department)
        ->create();
        $user = User::factory()
        ->for($department)
        ->create();
        Sanctum::actingAs($user,["*"]);
        $coords = fake()->localCoordinates();
        $response = $this->postJson(route("api.marcaciones.store"),[
            "position" => [
                "lat" => $coords["latitude"],
                "lng" => $coords["longitude"],
            ]
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseHas("marcacions",[
            "datetime" => now(),
            "type" => "in"
        ]);
    }
    /**
     * @test
     */
    public function can_store_a_marcacion_with_type_out(){
        now()->setTestNow(date("Y-m-d 16:00:00"));
        $department = Department::factory()->create();
        DepartmentHour::factory()
        ->for($department)
        ->create();
        $user = User::factory()
        ->for($department)
        ->create();
        Marcacion::factory()->for($user)->create();
        Sanctum::actingAs($user,["*"]);
        $coords = fake()->localCoordinates();
        $response = $this->postJson(route("api.marcaciones.store"),[
            "position" => [
                "lat" => $coords["latitude"],
                "lng" => $coords["longitude"],
            ]
        ]);
        $response->assertSuccessful();
        $this->assertDatabaseCount("marcacions",2);
        $this->assertDatabaseHas("marcacions",[
            "datetime" => now(),
            "type" => "out"
        ]);
    }
}
