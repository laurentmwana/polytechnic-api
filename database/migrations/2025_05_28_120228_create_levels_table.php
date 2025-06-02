<?php

use App\Enums\LevelProgrammeEnum;
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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias');
            $table->foreignId('option_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('programme', array_map(
                fn(LevelProgrammeEnum $enum) => $enum->value,
                LevelProgrammeEnum::cases(),
            ));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
