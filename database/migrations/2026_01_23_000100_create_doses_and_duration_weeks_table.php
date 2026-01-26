<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('doses')) {
            Schema::create('doses', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('name');
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('duration_weeks')) {
            Schema::create('duration_weeks', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('name');
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('doses');
        Schema::dropIfExists('duration_weeks');
    }
};
