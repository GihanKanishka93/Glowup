<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a new column with the correct name
            $table->string('user_name')->nullable(); // Use the correct type and attributes
        });
    
        // Copy data from old column to new column
       DB::table('users')->update(['user_name' => DB::raw('user_id')]);
    
        Schema::table('users', function (Blueprint $table) {
            // Drop the old column
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename the column back from 'user_name' to 'user_id'
            $table->renameColumn('user_name', 'user_id');
        });
    }
};
