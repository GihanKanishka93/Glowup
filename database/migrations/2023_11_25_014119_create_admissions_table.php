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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('patient_id')->unsigned();
            $table->dateTime('date_of_check_in')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
          //  $table->dateTime('date_of_check_in')->nullable()->default(new DateTime());
            $table->dateTime('date_of_check_out')->nullable();
            $table->date('plan_to_check_in')->nullable();
            $table->date('plan_to_check_out')->nullable();
            $table->tinyInteger('number_of_days')->nullable();

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('patient_id')->references('id')->on('patients');
            
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admissions');
    }
};
