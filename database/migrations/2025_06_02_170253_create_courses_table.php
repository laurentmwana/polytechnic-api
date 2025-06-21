<?php

use App\Enums\SemesterEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('credits');
            $table->foreignId('teacher_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('level_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('semester', array_map(
                fn(SemesterEnum $enum) => $enum->value,
                SemesterEnum::cases(),
            ));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
