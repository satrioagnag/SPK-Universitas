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
        Schema::create('alternatives_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alternative_id')
                ->constrained('alternatifs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('criterion_id')
                ->constrained('criterias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('sub_criterion_id')
                ->nullable()
                ->constrained('sub_criterias')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->decimal('Score', 10, 4);
            $table->timestamps();
            $table->unique(['alternative_id', 'criterion_id'], 'alt_crit_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatives_scores');
    }
};
