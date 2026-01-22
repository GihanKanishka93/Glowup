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
        Schema::create('admission_item', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('item_id');
            $table->foreignId('admission_id');
            $table->boolean('check_out')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_item');
    }
};
