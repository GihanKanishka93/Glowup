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
        Schema::table('admissions', function (Blueprint $table) {
            $table->tinyInteger('duration_of_stay');
            $table->string('reffered_ward', 100)->nullable();
            $table->string('reffered_counsultant', 100)->nullable();
            $table->string('treatment_history',100)->nullable();
            $table->string('special_requirements',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            //
        });
    }
};
