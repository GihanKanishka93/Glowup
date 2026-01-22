<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Add new column
        Schema::table('patients', function (Blueprint $table) {
            $table->string('father_contact2', 10)->nullable();
            $table->string('mother_contact2', 10)->nullable();
            $table->decimal('monthly_family_income', 10, 2)->nullable();
            $table->decimal('monthly_loan_diductions', 10, 2)->nullable();
            $table->string('transport_mode', 255)->nullable();
            $table->decimal('cost_of_travel', 10, 2)->nullable();
            $table->string('financial_support', 255)->nullable();
            $table->string('wdu_reside', 255)->nullable();
        });

        // Remove existing columns
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('father_address');
            $table->dropColumn('mother_address');
            $table->dropColumn('father_income');
            $table->dropColumn('mother_income');
        });
    }

    public function down()
    {
        // Reverse the changes made in the 'up' method
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('monthly_family_income');
            $table->decimal('father_income', 10, 2)->nullable();
            $table->decimal('mother_income', 10, 2)->nullable();
        });
    }

};