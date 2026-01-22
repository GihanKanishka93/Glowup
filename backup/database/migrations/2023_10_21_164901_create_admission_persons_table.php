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
        Schema::create('admission_persons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('admitions_id')->unsigned()->nullable();
            $table->bigInteger('person_id')->unsigned()->nullable();
            $table->dateTime('date_of_check_in')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('date_of_check_out')->nullable();

           // $table->foreign('admitions_id')->references('id')->on('admitions');
            $table->foreign('person_id')->references('id')->on('people');


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
        Schema::dropIfExists('admission_persons');
    }
};
