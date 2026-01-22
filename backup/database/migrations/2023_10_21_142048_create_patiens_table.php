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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('patient_id', 255);
            $table->string('name', 255)->nullable();
            $table->string('photo', 100)->nullable();
            $table->tinyInteger('gender')->comment('1 male, 2 female');
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('age_at_register');
            $table->text('allegics')->nullable();
            $table->text('remarks')->nullable();
            $table->text('basic_ilness')->nullable();
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
        Schema::dropIfExists('patients');
    }
};