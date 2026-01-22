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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('father_name',200)->nullable();
            $table->string('father_nic', 15)->nullable();
            $table->string('father_address', 250)->nullable();
            $table->string('father_contact',10)->nullable();
            $table->string('father_occupation',100)->nullable();
            $table->double('father_income', 10, 2)->nullable();
            $table->double('distance_to_suwa_arana', 10,2)->nullable();

            $table->string('mother_name',200)->nullable();
            $table->string('mother_nic', 15)->nullable();
            $table->string('mother_address', 250)->nullable();
            $table->string('mother_contact',10)->nullable();
            $table->string('mother_occupation',100)->nullable();
            $table->double('mother_income', 10, 2)->nullable();

            $table->string('guartian_name',200)->nullable();
            $table->string('guartian_nic', 15)->nullable();
            $table->string('guartian_address', 250)->nullable();
            $table->string('guartian_contact',10)->nullable();
            $table->tinyInteger('guartian_relationship_id');

            // $table->string('guartian_ocupation',100)->nullable();
            // $table->double('guartian_salary', 10, 2)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('father_name');
            $table->dropColumn('father_nic');
            $table->dropColumn('father_address');
            $table->dropColumn('father_contact');
            $table->dropColumn('father_occupation');
            $table->dropColumn('father_income');
            $table->dropColumn('distance_to_suwa_arana');

            $table->dropColumn('mother_name');
            $table->dropColumn('mother_nic');
            $table->dropColumn('mother_address');
            $table->dropColumn('mother_contact');
            $table->dropColumn('mother_occupation');
            $table->dropColumn('mother_income');

            $table->dropColumn('guartian_name');
            $table->dropColumn('guartian_nic');
            $table->dropColumn('guartian_address');
            $table->dropColumn('guartian_contact');  
            $table->dropColumn('guartian_relationship_id');
        });
    }
};
