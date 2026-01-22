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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id', 100);
            $table->string('last_name', 150)->nullable();
            $table->string('contact_number', 15)->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('designation', 100)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->string('ip', 15)->nullable();
            $table->softDeletes();
          //  $table->renameColumn('name','first_name');
             });
    }

    /**
     * Reverse the migrations.`
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('last_name');
            $table->dropColumn('column_number');
            $table->dropColumn('photo');
            $table->dropColumn('designation');
            $table->dropColumn('created_by');
            $table->dropColumn('ip');
            $table->dropColumn('deleted_at');
           // $table->renameColumn('first_name', 'name');
        });
    }
};
