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
        Schema::create('gdk_tests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contragent_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->unsignedBigInteger('act_no')->default(1);
            $table->decimal('coefficient');
            $table->decimal('applied_coefficient')->nullable();
            $table->decimal('water_usage')->nullable();
            $table->decimal('penalty_amount')->nullable();
            $table->decimal('tariff')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gdk_tests');
    }
};
