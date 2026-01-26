<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            if (!Schema::hasColumn('bills', 'print_status')) {
                $table->integer('print_status')->default(0)->after('payment_note');
            }
            if (!Schema::hasColumn('bills', 'bill_status')) {
                $table->integer('bill_status')->default(0)->after('print_status');
            }
            if (!Schema::hasColumn('bills', 'bill_type')) {
                $table->integer('bill_type')->default(0)->after('bill_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bills', function (Blueprint $table) {
            if (Schema::hasColumn('bills', 'bill_type')) {
                $table->dropColumn('bill_type');
            }
            if (Schema::hasColumn('bills', 'bill_status')) {
                $table->dropColumn('bill_status');
            }
            if (Schema::hasColumn('bills', 'print_status')) {
                $table->dropColumn('print_status');
            }
        });
    }
};
