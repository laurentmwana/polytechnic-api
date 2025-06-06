<?php

namespace Tests\Feature\Other;

use Tests\TestCase;
use App\Models\YearAcademic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class YearCurrentControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_returns_the_current_year_academic()
    {
        // Création d'une année académique non fermée
        $currentYear = YearAcademic::factory()->create([
            'is_closed' => false,
            'start' => 2024,
            'end' => 2025,
            'name' => '2024-2025',
        ]);

        // Création d'une année fermée
        YearAcademic::factory()->create([
            'is_closed' => true,
        ]);

        $response = $this->getJson(route('^year.current'));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $currentYear->id,
                    'name' => $currentYear->name,
                    'start' => $currentYear->start,
                    'end' => $currentYear->end,
                    'is_closed' => false,
                    // autres champs selon ta ressource YearItemResource
                ]
            ]);
    }


    public function test_returns_null_when_no_current_year_found()
    {
        // Toutes les années sont fermées ou inexistantes
        YearAcademic::factory()->create([
            'is_closed' => true,
        ]);

        $response = $this->getJson('/api/other/year-current');

        $response->assertStatus(200)
            ->assertJson([
                'data' => null,
            ]);
    }
}
