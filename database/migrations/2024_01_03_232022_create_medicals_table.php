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
        Schema::create('medicals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('admission_id')->nullable()->unsigned();
            $table->bigInteger('patient_id')->nullable()->unsigned();

            $table->string('medical_diagnosis', 250)->nullable();
            $table->text('medical_history')->nullable();
            $table->string('allergies',250)->nullable();
            $table->text('current_signs_and_sysmptoms')->nullable();

         //   $table->text('current_medication')->nullable(); 
            $table->boolean('any_pain')->nullable()->default(false);
            $table->string('type_of_pain',250)->nullable()->default(0);
            $table->tinyInteger('pain_score');

            $table->double('temperature', 6, 2)->nullable();
            $table->string('blood_pressure', 39)->nullable();
            $table->integer('heart_reate')->unsigned()->nullable();
            $table->integer('breaths_per_minute')->unsigned()->nullable();

            $table->boolean('sensory')->nullable()->default(false);
            $table->boolean('musculoskelete')->nullable()->default(false);
            $table->boolean('integumentary')->nullable()->default(false);
            $table->boolean('neurovascular')->nullable()->default(false);
            $table->boolean('circularory')->nullable()->default(false);
            $table->boolean('respiratory')->nullable()->default(false);
            $table->boolean('dental')->nullable()->default(false);
            $table->boolean('psychosocial')->nullable()->default(false);
            $table->boolean('nutrition')->nullable()->default(false);
            $table->boolean('elimination')->nullable()->default(false);
            $table->boolean('trouble_sleeping')->nullable()->default(false);
            $table->boolean('nausea_and_vomiting')->nullable()->default(false);
            $table->boolean('breathing_problem')->nullable()->default(false);
            $table->boolean('appetite_problem')->nullable()->default(false);
            
                $table->string('sensory_comment', 100)->nullable()->default('');
            $table->string('musculoskelete_comment', 100)->nullable()->default('');
            $table->string('integumentary_comment', 100)->nullable()->default('');
            $table->string('neurovascular_comment', 100)->nullable()->default('');
            $table->string('circularory_comment', 100)->nullable()->default('');
            $table->string('respiratory_comment', 100)->nullable()->default('');
            $table->string('dental_comment', 100)->nullable()->default('');
            $table->string('psychosocial_comment', 100)->nullable()->default('');
            $table->string('nutrition_comment', 100)->nullable()->default('');
            $table->string('elimination_comment', 100)->nullable()->default('');
            $table->string('trouble_sleeping_comment', 100)->nullable()->default('');
            $table->string('nausea_and_vomiting_comment', 100)->nullable()->default('');
            $table->string('breathing_problem_comment', 100)->nullable()->default('');
            $table->string('appetite_problem_comment', 100)->nullable()->default('');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};
