<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCurrentSignsAndSysmptomsColumnTypeInMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicals', function (Blueprint $table) {
            // Change 'current_signs_and_sysmptoms' column type from text to tinyint
            $table->tinyInteger('current_signs_and_sysmptoms')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // If needed, you can define the reverse migration here
        // However, down() is not necessary for a column type change in this case
    }
}