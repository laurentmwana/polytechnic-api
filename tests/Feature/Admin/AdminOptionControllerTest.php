<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Option;
use App\Models\Department;
use App\Enums\RoleUserEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminOptionControllerTest extends TestCase
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

    public function test_lists_options_with_department()
    {
        $department = Department::factory()->create();

        Option::factory()->count(3)->create([
            'department_id' => $department->id,
        ]);

        $response = $this->getJson(route('#option.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'department' => [
                            'id',
                            'name',
                            // autres champs du département
                        ],
                        // autres champs de l'option
                    ]
                ],
                'links',
                'meta',
            ]);
    }


    public function test_creates_an_option()
    {
        $department = Department::factory()->create();

        $payload = [
            'name' => 'Nouvelle Option',
            'department_id' => $department->id,
            // ajoute ici les autres champs requis par OptionRequest
        ];

        $response = $this->postJson(route('#option.store'), $payload);

        $response->assertStatus(201)
            ->assertJsonStructure(['data']);

        $this->assertDatabaseHas('options', [
            'name' => 'Nouvelle Option',
            'department_id' => $department->id,
        ]);
    }


    public function test_shows_an_option()
    {
        $option = Option::factory()->create();

        $response = $this->getJson(route('#option.store', ['id' => $option->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    // autres champs
                ]
            ]);
    }


    public function test_updates_an_option()
    {
        $option = Option::factory()->create([
            'name' => 'Ancien Nom',
        ]);

        $payload = [
            'name' => 'Nom Modifié',
            // autres champs à mettre à jour si besoin
        ];

        $response = $this->putJson(route('#option.put', ['id' => $option->id]), $payload);

        $response->assertStatus(200)
            ->assertJson(['state' => true]);

        $this->assertDatabaseHas('options', [
            'id' => $option->id,
            'name' => 'Nom Modifié',
        ]);
    }


    public function test_deletes_an_option()
    {
        $option = Option::factory()->create();

        $response = $this->deleteJson("route('#option.destroy", ['id' => $option->id]);

        $response->assertStatus(200)
            ->assertJson(['state' => true]);

        $this->assertDatabaseMissing('options', [
            'id' => $option->id,
        ]);
    }


    public function test_returns_404_when_option_not_found()
    {
        $response = $this->getJson('/api/admin/option/999999');

        $response->assertStatus(404);
    }
}
