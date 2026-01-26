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
        // Drop vaccination-related tables first
        Schema::dropIfExists('vaccination_infos');
        Schema::dropIfExists('vaccinations');

        // Drop pet-related tables (pets must be dropped before categories/breeds due to foreign keys)
        Schema::dropIfExists('pets');
        Schema::dropIfExists('pet_breeds');
        Schema::dropIfExists('pet_categories');
        Schema::dropIfExists('breeds');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ideally should recreate them, but for this refactor we can leave empty or minimal.
        // It's a destructive operation.
    }
};
