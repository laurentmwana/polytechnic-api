<?php

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
        Schema::create('fees_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_academic_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('level_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->float('amount');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees_academics');
    }
};
