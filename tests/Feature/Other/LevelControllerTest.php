<?php

namespace Tests\Feature\Other;


use Tests\TestCase;
use App\Models\Level;
use App\Models\Option;
use App\Models\YearAcademic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LevelControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_lists_levels_with_option_and_year_academic()
    {
        $option = Option::factory()->create();
        $yearAcademic = YearAcademic::factory()->create();

        Level::factory()->count(3)->create([
            'option_id' => $option->id,
            'year_academic_id' => $yearAcademic->id,
        ]);

        $response = $this->getJson(route('^level.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'option' => [
                            'id',
                            'name',
                            // autres champs selon ta ressource OptionItemResource
                        ],
                        'year_academic' => [
                            'id',
                            'name',
                            'start',
                            'end',
                        ],
                    ]
                ],
                'links',
                'meta',
            ]);
    }


    public function test_shows_a_single_level()
    {
        $option = Option::factory()->create();
        $yearAcademic = YearAcademic::factory()->create();

        $level = Level::factory()->create([
            'option_id' => $option->id,
            'year_academic_id' => $yearAcademic->id,
        ]);

        $response = $this->getJson(route('^level.show', ['id' => $level->id]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'option' => [
                        'id',
                        'name',
                        // autres champs
                    ],
                    'year_academic' => [
                        'id',
                        'name',
                        'start',
                        'end',
                        // autres champs
                    ],
                    // autres champs
                ]
            ]);
    }


    public function test_returns_404_when_level_not_found()
    {
        $response = $this->getJson(route('^level.show', ['id' => 4555]));

        $response->assertStatus(404);
    }
}
