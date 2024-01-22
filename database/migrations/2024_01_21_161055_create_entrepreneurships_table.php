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
        Schema::create('entrepreneurships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('reason');
            $table->string('location');
            $table->string('entr_form');
            $table->string('sector');
            $table->string('product');
            $table->string('num_employees');
            $table->string('capital_status');
            $table->string('workforce_fac'); //for workforce facilities
            $table->date('start_time');
            $table->string('ent_count');
            $table->string('chg_reason');
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
        Schema::dropIfExists('entrepreneurships');
    }
};
