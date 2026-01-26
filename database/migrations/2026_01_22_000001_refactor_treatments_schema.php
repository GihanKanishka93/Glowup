<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            // Add patient_id FK
            $table->unsignedBigInteger('patient_id')->after('id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

            // Drop pet_id
            $table->dropForeign(['pet_id']); // Assuming default index naming, might need to be specific if fails
            $table->dropColumn('pet_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treatments', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');

            $table->unsignedBigInteger('pet_id')->nullable();
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });
    }
};
