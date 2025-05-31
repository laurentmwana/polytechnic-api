<?php

namespace Tests\Feature\Other;

use Tests\TestCase;
use App\Models\Department;
use App\Models\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DepartmentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_departments_with_options()
    {
        $departments = Department::factory()
            ->count(3)
            ->create()
            ->each(function ($department) {
                Option::factory()->count(2)->create(['department_id' => $department->id]);
            });

        $response = $this->getJson(route('^department.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'options' => [
                            '*' => ['id', 'name', 'department_id']
                        ],
                    ]
                ],
                'links',
                'meta',
            ]);
    }

    public function test_shows_a_single_department()
    {
        $department = Department::factory()->create();

        $response = $this->getJson(route('^department.show', ['id' => $department->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ]
            ]);
    }


    public function test_returns_404_when_department_not_found()
    {
        $response = $this->getJson(route('^department.show', ['id' => 66952]));

        $response->assertStatus(404);
    }
}
