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
        Schema::create('gdk_test_measurements_pivot', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('test_id')->constrained('gdk_tests')->cascadeOnDelete();
            $table->foreignId('measurement_id')->constrained('gdk_measurements');
            $table->decimal('proposed_coefficient')->nullable();
            $table->decimal('real_coefficient')->nullable();
            $table->decimal('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
