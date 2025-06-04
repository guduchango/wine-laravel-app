<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WineControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        return ['Authorization' => 'Bearer ' . $token];
    }

    public function test_can_list_wines()
    {
        Wine::factory()->count(3)->create();
        $headers = $this->authenticate();

        $response = $this->getJson('/api/wines', $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'description', 'created_at', 'updated_at']
        ]);
    }

    public function test_can_create_wine()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Cabernet Sauvignon',
            'winery' => 'Bodega Mendoza',
            'variety' => 'Malbec',
            'vintage' => 2020,
            'country' => 'Argentina',
        ];

        $response = $this->actingAs($user)->postJson('/api/wines', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('wines', ['name' => 'Cabernet Sauvignon']);
    }

    public function test_can_show_a_wine()
    {
        $headers = $this->authenticate();
        $wine = Wine::factory()->create();

        $response = $this->getJson("/api/wines/{$wine->id}", $headers);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $wine->id,
            'name' => $wine->name,
        ]);
    }

    public function test_can_update_a_wine()
    {
        $headers = $this->authenticate();
        $wine = Wine::factory()->create();

        $data = ['name' => 'Updated Wine'];

        $response = $this->putJson("/api/wines/{$wine->id}", $data, $headers);

        $response->assertStatus(200);
        $this->assertDatabaseHas('wines', ['id' => $wine->id, 'name' => 'Updated Wine']);
    }

    public function test_can_delete_a_wine()
    {
        $headers = $this->authenticate();
        $wine = Wine::factory()->create();

        $response = $this->deleteJson("/api/wines/{$wine->id}", [], $headers);

        $response->assertStatus(200); // o 204 si lo manejás así
        $this->assertDatabaseMissing('wines', ['id' => $wine->id]);
    }
}
