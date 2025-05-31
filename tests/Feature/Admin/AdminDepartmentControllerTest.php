<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Option;
use App\Models\Department;
use App\Enums\RoleUserEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminDepartmentControllerTest extends TestCase
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

    public function test_lists_departments_with_options()
    {
        // Création de départements avec options associées
        $departments = Department::factory()
            ->count(3)
            ->create()
            ->each(function ($department) {
                Option::factory()->count(2)->create(['department_id' => $department->id]);
            });

        $response = $this->getJson(route('#department.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'options' => [
                            '*' => ['id', 'name', 'department_id']
                        ],
                        // autres champs selon ta ressource
                    ]
                ],
                'links',
                'meta',
            ]);
    }


    public function test_shows_a_single_department()
    {
        $department = Department::factory()->create();

        $response = $this->getJson(route('#department.show', ['id' => $department->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    // autres champs selon ta ressource
                ]
            ]);
    }


    public function test_updates_a_department()
    {
        $department = Department::factory()->create([
            'name' => 'Old Name',
        ]);

        $payload = [
            'name' => 'New Updated Name',
            // ajoute ici les autres champs validés par DepartmentRequest
        ];

        $response = $this->putJson(route('#department.update', ['id' => $department->id]), $payload);

        $response->assertStatus(200)
            ->assertJson(['state' => true]);

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'name' => 'New  Updated Name',
        ]);
    }


    public function test_returns_404_when_updating_non_existing_department()
    {
        $response = $this->putJson(route('#department.show', ['id' => 9999]), [
            'name' => 'Test',
        ]);

        $response->assertStatus(404);
    }
}
