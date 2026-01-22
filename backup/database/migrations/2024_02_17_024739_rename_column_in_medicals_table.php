<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnInMedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medicals', function (Blueprint $table) {
            // $table->renameColumn('current_signs_and_sysmptoms', 'patient_on_steroids');
            \DB::statement('ALTER TABLE medicals CHANGE current_signs_and_sysmptoms patient_on_steroids TINYINT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medicals', function (Blueprint $table) {
            // Reverse the renaming in the down method
            $table->renameColumn('patient_on_steroids', 'current_signs_and_sysmptoms');
        });
    }
}