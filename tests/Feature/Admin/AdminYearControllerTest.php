<?php


namespace Tests\Feature\Api\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Enums\RoleUserEnum;
use App\Models\YearAcademic;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminYearControllerTest extends TestCase
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


    public function test_lists_years()
    {
        YearAcademic::create([
            'name' => '2022-2023',
            'start' => 2022,
            'end' => 2023,
            'is_closed' => false,
        ]);

        $response = $this->getJson(route('#year.index'));

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }


    public function test_shows_a_year()
    {
        $year = YearAcademic::create([
            'name' => '2022-2023',
            'start' => 2022,
            'end' => 2023,
            'is_closed' => false,
        ]);

        $response = $this->getJson(route('#year.show', ['id' => $year->id]));

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
    }


    public function test_closes_a_year_and_creates_new()
    {
        $year = YearAcademic::create(['is_closed' => false, 'end' => 2025, 'start' => 2024]);

        $response = $this->postJson(route('#year.closed', ['id' => $year->id]));

        $response->assertStatus(200)
            ->assertJsonStructure(['data']);
        $this->assertDatabaseHas('year_academics', ['id' => $year->id, 'is_closed' => true]);
        $this->assertDatabaseHas('year_academics', ['start' => 2024, 'end' => 2025]);
    }
}
