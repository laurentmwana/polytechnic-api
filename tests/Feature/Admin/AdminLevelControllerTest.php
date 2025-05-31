<?php

namespace Tests\Feature\Api\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Level;
use App\Enums\RoleUserEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminLevelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'roles' => [RoleUserEnum::ADMIN],
        ]);

        $this->user = $user;
    }


    public function test_lists_levels()
    {
        Level::factory()->count(2)->create();

        $response = $this->getJson('/api/admin/level');

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }


    public function test_creates_a_level()
    {
        $payload = Level::factory()->make()->toArray();

        $response = $this->postJson(route('#level.store'), $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);
    }


    public function test_shows_a_level()
    {
        $level = Level::factory()->create();

        $response = $this
            ->getJson(route('#level.show', ['id' => $level->id]));

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }


    public function test_updates_a_level()
    {
        $level = Level::factory()->create();
        $payload = ['name' => 'Updated Level'];

        $response = $this->putJson(route('#level.update', ['id' => $level->id]), $payload);

        $response->assertStatus(200)
            ->assertJson(['state' => true]);
    }


    public function test_deletes_a_level()
    {
        $level = Level::factory()->create();

        $response = $this->deleteJson(route('#level.destroy', ['id' => $level->id]));

        $response->assertStatus(200)
            ->assertJson(['state' => true]);
        $this->assertDatabaseMissing('levels', ['id' => $level->id]);
    }
}
