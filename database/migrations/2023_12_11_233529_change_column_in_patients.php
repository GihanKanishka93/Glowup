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
            $table->string('guardian_name', 250)->nullable();
            $table->string('guardian_nic', 13)->nullable();
            $table->string('guardian_address', 255)->nullable();
            $table->string('guardian_contact', 12)->nullable();
          //  $table->integer('guardian_relationship_id', 10)->unsigned()->nullable();
            $table->integer('guardian_relationship_id')->unsigned()->nullable()->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            //
        });
    }
};
