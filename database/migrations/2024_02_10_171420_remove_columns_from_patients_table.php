<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('allergies');
            $table->dropColumn('remarks');
            $table->dropColumn('basic_ilness');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If you ever need to rollback, you can recreate the columns
        Schema::table('patients', function (Blueprint $table) {
            $table->string('allergies')->nullable();
            $table->text('remarks')->nullable();
            $table->string('basic_ilness')->nullable();
        });
    }
}