<?php

use App\Enums\TargetEventENum;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('tags');
            $table->string('description');
            $table->longText('content');
            $table->string('url')->nullable();
            $table->dateTime('start_at')->default(now()->addDays(3));
            $table->foreignId('level_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('year_academic_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
