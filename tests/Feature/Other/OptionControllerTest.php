<?php

namespace Tests\Feature\Other;

use Tests\TestCase;
use App\Models\Option;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OptionControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_lists_options_with_department()
    {
        $department = Department::factory()->create();

        Option::factory()->count(3)->create([
            'department_id' => $department->id,
        ]);

        $response = $this->getJson(route('^option.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'department' => [
                            'id',
                            'name',
                            // autres champs selon ta ressource DepartmentItemResource
                        ],
                        // autres champs selon ta ressource OptionItemResource
                    ]
                ],
                'links',
                'meta',
            ]);
    }


    public function test_shows_a_single_option()
    {
        $department = Department::factory()->create();

        $option = Option::factory()->create([
            'department_id' => $department->id,
        ]);

        $response = $this->getJson(route('^option.show', ['id' => $option->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'department' => [
                        'id',
                        'name',
                        // autres champs
                    ],
                    // autres champs
                ]
            ]);
    }


    public function test_returns_404_when_option_not_found()
    {
        $response = $this->getJson(route('^option.show', ['id' => 456]));

        $response->assertStatus(404);
    }
}
