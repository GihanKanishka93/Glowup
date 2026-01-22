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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 255)->nullable();
            $table->string('nic', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('contact_number_one', 11)->nullable();
            $table->string('contact_number_two', 11)->nullable();
            $table->tinyInteger('relationship_id');
            $table->tinyInteger('is_guardian')->default(0);
            $table->bigInteger('patient_id')->nullable()->unsigned();
            $table->foreign('patient_id')->references('id')->on('patients');
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
        Schema::dropIfExists('people');
    }
};
