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
        Schema::create('sub_criterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criterion_id')
                ->constrained('criterias')
                ->cascadeonUpdate()
                ->cascadeOnDelete();
            $table->string('label'); // e.g., 'A1', 'A2', '>5jt'
            $table->decimal('Score', 10, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_criterias');
    }
};
