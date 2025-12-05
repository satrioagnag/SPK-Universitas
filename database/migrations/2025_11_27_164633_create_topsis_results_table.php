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
        Schema::create('topsis_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calculation_run_id')
            ->constrained('calculation_runs')
            ->cascadeonDelete()
            ->cascadeonUpdate();
            $table->foreignId('alternative_id')
            ->constrained('alternatifs')
            ->cascadeonDelete()
            ->cascadeonUpdate();
            $table->decimal('score', 10, 6);
            $table->unsignedInteger('rank');
            $table->timestamps();

            $table->unique(['calculation_run_id', 'alternative_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topsis_results');
    }
};
