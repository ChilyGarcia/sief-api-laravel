<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('health_professional_id');
            $table->unsignedBigInteger('patient_id');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['scheduled', 'canceled', 'completed']);

            $table->foreign('health_professional_id')->references('id')->on('health_professionals')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
