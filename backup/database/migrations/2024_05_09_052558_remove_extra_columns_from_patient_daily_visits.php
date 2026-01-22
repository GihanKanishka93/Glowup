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
        Schema::table('patient_daily_visits', function (Blueprint $table) {
             $table->dropColumn(['family_history', 'economic_status', 'social_history']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_daily_visits', function (Blueprint $table) {
            $table->longText('family_history')->nullable(); 
            $table->longText('economic_status')->nullable(); 
            $table->longText('social_history')->nullable(); 
        });
    }
};
