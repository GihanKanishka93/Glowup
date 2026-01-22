<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add a new column for the desired name
            $table->string('allergies')->nullable();
        });

        // Copy data from 'allegics' to 'allergies'
        DB::table('patients')->update(['allergies' => DB::raw('allegics')]);

        Schema::table('patients', function (Blueprint $table) {
            // Drop the old column 'allegics'
            $table->dropColumn('allegics');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add 'allegics' back to reverse the change
            $table->string('allegics')->nullable();
        });

        // Copy data from 'allergies' back to 'allegics'
        DB::table('patients')->update(['allegics' => DB::raw('allergies')]);

        Schema::table('patients', function (Blueprint $table) {
            // Drop the new column 'allergies'
            $table->dropColumn('allergies');
        });
    }
};

