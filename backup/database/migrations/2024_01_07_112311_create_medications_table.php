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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->bigInteger('admission_id')->nullable()->unsigned();
            $table->bigInteger('patient_id')->nullable()->unsigned();
            
            $table->string('name', 250);
            $table->string('dose', 100)->nullable();
            $table->string('frequency', 100)->nullable();
            $table->string('route', 100)->nullable();
            $table->string('indication', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
