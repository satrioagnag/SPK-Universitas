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
        Schema::create('criteria_pairwises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_row_id')
                ->constrained('criterias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('criterion_column_id')
                ->constrained('criterias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->double('Value');
            $table->timestamps();
            $table->unique(['criterion_row_id', 'criterion_column_id'], 'crit_pair_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criteria_pairwises');
    }
};
