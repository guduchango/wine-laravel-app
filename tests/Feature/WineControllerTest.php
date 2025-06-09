<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class WineControllerTest extends TestCase
{
    //use RefreshDatabase;

    protected static User $user;
    protected static array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        if (!isset(self::$user)) {
            self::$user = User::factory()->create();
            $token = self::$user->createToken('auth_token')->plainTextToken;
            self::$headers = ['Authorization' => 'Bearer ' . $token];
            Log::info("Usuario creado una sola vez con ID " . self::$user->id);
        }
    }

    public function test_can_create_wine()
    {

        $wine = Wine::factory()->make(
            [
                'user_id' => self::$user->id,
                'name' => 'Cabernet Sauvignon',
                'variety' => 'Malbec',
                'vintage' => 2020,
            ]
        );

        $data = $wine->toArray();

        $response = $this->postJson('/api/wines', $data, self::$headers);
        $response->assertStatus(201);
        $this->assertDatabaseHas('wines', ['name' => 'Cabernet Sauvignon']);
    }


    public function test_can_show_a_wine()
    {
        $wine = Wine::factory()->create(
            ['user_id' => self::$user->id]
        );
        $response = $this->getJson("/api/wines/{$wine->id}", self::$headers);
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $wine->id,
            'name' => $wine->name,
        ]);
    }

    public function test_can_update_a_wine()
    {
        $wine = Wine::where('user_id',self::$user->id)
            ->first();

        $wineData = Wine::factory()->make(
            [
                'id' => $wine->id,
                'user_id' => self::$user->id,
                'name' => 'Updated Wine'
            ]
        );

        $data = $wineData->toArray();
        $response = $this->putJson("/api/wines/{$wine->id}", $data, self::$headers);
        $response->assertStatus(200);
        $this->assertDatabaseHas('wines', ['id' => $wine->id, 'name' => 'Updated Wine']);
    }

    public function test_can_delete_a_wine()
    {

        $wine = Wine::factory()->create(
            ['user_id' => self::$user->id]
        );

        $response = $this->deleteJson("/api/wines/{$wine->id}", [], self::$headers);

        $response->assertStatus(200); // o 204 si lo manejás así
        $this->assertDatabaseMissing('wines', ['id' => $wine->id]);
    }

}
