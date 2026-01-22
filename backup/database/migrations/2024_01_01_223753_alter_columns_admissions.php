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
        Schema::table('admissions', function (Blueprint $table) {
            $table->datetime('plan_to_check_in')->change()->nullable();
            $table->datetime('plan_to_check_out')->change()->nullable();
            $table->string('agreement_file', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admissions', function (Blueprint $table) {
            $table->date('plan_to_check_in')->change()->nullable();
            $table->date('plan_to_check_out')->change()->nullable();
            $table->dropColumn('agreement_file');
        });
    }
};
