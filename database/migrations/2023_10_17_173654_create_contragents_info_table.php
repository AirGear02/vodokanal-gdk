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
        Schema::create('contragents_info', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('contragent_id')->constrained()->cascadeOnDelete();
            $table->date('date')->nullable();
            $table->unsignedDecimal('avg_water_usage')->nullable();
            $table->date('gdk_exceeding_letter_date')->nullable();
            $table->date('invoice_issuance_date')->nullable();
            $table->date('invoice_due_date')->nullable();
            $table->text('comment_1')->nullable();
            $table->text('comment_2')->nullable();
            $table->text('penalty_note')->nullable();
            $table->date('application_increasing_coef_date')->nullable();
            $table->date('disconnection_notification_date')->nullable();
            $table->date('disconnection_date')->nullable();
            $table->boolean('is_disconnected')->nullable();
            $table->unsignedDecimal('penalty_amount')->nullable();
            $table->text('penalty_comment')->nullable();
            $table->decimal('coefficient')->nullable();
            $table->decimal('applied_coefficient')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contragents_infos');
    }
};
