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
        Schema::create('works', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('waiting_for_job');
            $table->string('location');
            $table->string('workplace_name');
            $table->string('position');
            $table->string('num_of_employees');
            $table->string('company_type');
            $table->string('employment_duration');
            $table->string('change_job_reason');
            $table->string('working_hours');
            $table->double('income_amount');

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
