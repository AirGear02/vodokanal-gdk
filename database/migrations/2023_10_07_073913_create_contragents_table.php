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
        Schema::create('contragents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('type_id')->constrained('contragent_types');
            $table->string('name', 256);
            $table->string('edrpou', 8);
            $table->string('contract_no', 16)->unique();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contragents');
    }
};
