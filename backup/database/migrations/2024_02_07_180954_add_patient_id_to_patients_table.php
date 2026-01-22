<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('patients', function (Blueprint $table) {
        // $table->string('patient_id', 255); //THIS HAS BEEN ALREADY CREATED FROM A EARLIET MIGRATION
    });
}




    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('patient_id');
        });
    }
};