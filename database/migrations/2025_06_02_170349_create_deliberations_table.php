<?php

use App\Enums\SemesterEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class  extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliberations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('year_academic_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->dateTime('start_at');
            $table->enum('semester', array_map(
                fn(SemesterEnum $enum) => $enum->value,
                SemesterEnum::cases(),
            ));

            $table->longText('criteria');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliberations');
    }
};
