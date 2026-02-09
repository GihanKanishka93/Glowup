<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('reminder_logs')) {
            return;
        }

        Schema::table('reminder_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('reminder_logs', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->nullable()->after('reminder_type');
            }
        });

        if (Schema::hasColumn('reminder_logs', 'pet_id') && Schema::hasColumn('reminder_logs', 'patient_id')) {
            DB::statement('UPDATE reminder_logs SET patient_id = pet_id WHERE patient_id IS NULL');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('reminder_logs')) {
            return;
        }

        if (!Schema::hasColumn('reminder_logs', 'pet_id')) {
            Schema::table('reminder_logs', function (Blueprint $table) {
                $table->unsignedBigInteger('pet_id')->nullable()->after('reminder_type');
            });
        }

        if (Schema::hasColumn('reminder_logs', 'pet_id') && Schema::hasColumn('reminder_logs', 'patient_id')) {
            DB::statement('UPDATE reminder_logs SET pet_id = patient_id WHERE pet_id IS NULL');
        }
    }
};
