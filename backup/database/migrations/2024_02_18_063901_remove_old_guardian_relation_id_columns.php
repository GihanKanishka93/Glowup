<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
           $table->dropColumn('guartian_relationship_id');
           $table->dropColumn('guardian_relationship_id');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
