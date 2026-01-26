<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('treatments') && !Schema::hasColumn('treatments', 'next_clinic_reminder_sent_at')) {
            Schema::table('treatments', function (Blueprint $table) {
                $table->timestamp('next_clinic_reminder_sent_at')->nullable()->after('next_clinic_weeks');
            });
        }

        if (Schema::hasTable('vaccination_infos') && !Schema::hasColumn('vaccination_infos', 'reminder_sent_at')) {
            Schema::table('vaccination_infos', function (Blueprint $table) {
                $table->timestamp('reminder_sent_at')->nullable()->after('next_vacc_weeks');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('treatments') && Schema::hasColumn('treatments', 'next_clinic_reminder_sent_at')) {
            Schema::table('treatments', function (Blueprint $table) {
                $table->dropColumn('next_clinic_reminder_sent_at');
            });
        }

        if (Schema::hasTable('vaccination_infos') && Schema::hasColumn('vaccination_infos', 'reminder_sent_at')) {
            Schema::table('vaccination_infos', function (Blueprint $table) {
                $table->dropColumn('reminder_sent_at');
            });
        }
    }
};
