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
        Schema::create('calculation_runs', function (Blueprint $table) {
            $table->id();
            $table->enum('method', ['AHP', 'TOPSIS']);
            $table->string('note')->nullable();
            $table->timestamp('run_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_runs');
    }
};
