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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pet_id', 255);
            $table->string('name', 255)->nullable();
            $table->string('photo', 100)->nullable();
            $table->tinyInteger('gender')->comment('1 male, 2 female');
            $table->date('date_of_birth')->nullable();
            $table->string('age_at_register', 255)->nullable();
            $table->string('weight', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->bigInteger('pet_category')->nullable()->unsigned();
            $table->foreign('pet_category')->references('id')->on('pet_categories');
            $table->bigInteger('pet_breed')->nullable()->unsigned();
            $table->foreign('pet_breed')->references('id')->on('pet_breeds');
            $table->text('remarks')->nullable();
            $table->text('basic_ilness')->nullable();
            $table->string('owner_name', 255)->nullable();
            $table->string('owner_nic', 100)->nullable();
            $table->string('owner_occupation', 100)->nullable();
            $table->string('owner_contact', 100)->nullable();
            $table->string('owner_address', 255)->nullable();
            $table->string('owner_email', 100)->nullable();
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
        Schema::dropIfExists('pets');
    }
};
