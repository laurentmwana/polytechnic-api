<?php

namespace Database\Seeders;

use App\Models\Actuality;
use App\Models\Comment;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Enums\RoleUserEnum;
use App\Models\ActualLevel;
use App\Models\YearAcademic;
use Illuminate\Database\Seeder;
use Database\Seeders\DefaultSeeder;

class DatabaseSeeder extends Seeder
{
    private const ADMIN_USERS = [
        ['name' => 'Graciella', 'email' => "graciellamabs@gmail.com"],
        ['name' => 'Glodi', 'email' => "glodintumba50@gmail.com"],
        ['name' => 'Yves', 'email' => "yvesmetena137@gmail.com"],
        ['name' => 'Joel', 'email' => "joeltshipamba2024@gmail.com"],
        ['name' => 'Labeya', 'email' => "laurentmwn@gmail.com"],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DefaultSeeder::class);

        foreach (self::ADMIN_USERS as $value) {
            User::factory()->create([
                ...$value,
                'roles' => [RoleUserEnum::ADMIN->value],
            ]);
        }
    }
}
