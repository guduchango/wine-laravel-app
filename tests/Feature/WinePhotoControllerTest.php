<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wine;
use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WinePhotoControllerTest extends TestCase
{

    //use RefreshDatabase;

    public function test_can_upload_multiple_photos()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $wine = Wine::factory()->create(['user_id' => $user->id]);

        $files = [
            UploadedFile::fake()->image('photo1.jpg'),
            UploadedFile::fake()->image('photo2.jpg'),
        ];

        $response = $this->postJson("/api/wines/{$wine->id}/multi-photos", [
            'photos' => $files,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'photos' => [
                ['id', 'wine_id', 'path', 'created_at', 'updated_at'],
            ],
        ]);

        foreach ($files as $file) {
            Storage::disk('public')->assertExists('wine_photos/' . $file->hashName());
        }
    }

    public function test_can_list_photos_for_a_wine()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $wine = Wine::factory()->create(['user_id' => $user->id]);

        Photo::factory()->count(3)->create([
            'wine_id' => $wine->id,
        ]);

        $response = $this->getJson("/api/wines/{$wine->id}/photos");

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_delete_a_photo()
    {
        Log::info('hola1');
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);
        Log::info('hola2');
        $wine = Wine::factory()->create(['user_id' => $user->id]);
        Log::info('hola3');
        $file = UploadedFile::fake()->image('photo.jpg');
        $path = $file->store('wine_photos', 'public');
        Log::info('hola4');
        $photo = Photo::create([
            'wine_id' => $wine->id,
            'path' => $path,
        ]);
        Log::info('photo created: ' . $photo->id);

        $response = $this->deleteJson("/api/photos/{$photo->id}");

        $response->assertStatus(200);
        Storage::disk('public')->assertMissing($path);
        $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
    }
}
