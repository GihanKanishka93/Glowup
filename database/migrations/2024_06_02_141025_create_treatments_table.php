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
        if (Schema::hasTable('treatments')) {
            return;
        }

        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Legacy vet relation kept for backward compatibility; removed later in refactor migration
            $table->bigInteger('pet_id')->nullable()->unsigned();
            $table->foreign('pet_id')->references('id')->on('pets');

            $table->bigInteger('doctor_id')->nullable()->unsigned();
            $table->foreign('doctor_id')->references('id')->on('doctors');

            $table->string('history_complaint', 255)->nullable();
            $table->string('clinical_observation', 255)->nullable();
            $table->string('remarks', 255)->nullable();
            $table->date('treatment_date')->nullable();
            $table->date('next_clinic_date')->nullable();
            $table->string('next_clinic_weeks', 100)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('treatments');
    }
};
