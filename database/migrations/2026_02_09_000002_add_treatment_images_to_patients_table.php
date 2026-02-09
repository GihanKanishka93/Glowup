<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('patients')) {
            return;
        }

        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'before_treatment_image')) {
                $table->string('before_treatment_image')->nullable()->after('photo');
            }
            if (!Schema::hasColumn('patients', 'after_treatment_image')) {
                $table->string('after_treatment_image')->nullable()->after('before_treatment_image');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('patients')) {
            return;
        }

        Schema::table('patients', function (Blueprint $table) {
            if (Schema::hasColumn('patients', 'after_treatment_image')) {
                $table->dropColumn('after_treatment_image');
            }
            if (Schema::hasColumn('patients', 'before_treatment_image')) {
                $table->dropColumn('before_treatment_image');
            }
        });
    }
};
