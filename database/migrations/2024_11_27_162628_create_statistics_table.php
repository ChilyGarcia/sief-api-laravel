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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('career_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->string('graduate_students');
            $table->string('retired_students');
            $table->string('enrolled_students');
            $table->string('admited_students');

            $table->foreign('career_id')->references('id')->on('careers');
            $table->foreign('academic_period_id')->references('id')->on('academic_periods');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
