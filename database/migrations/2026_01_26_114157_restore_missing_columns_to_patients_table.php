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
        Schema::table('patients', function (Blueprint $table) {
            if (!Schema::hasColumn('patients', 'allegics')) {
                $table->text('allegics')->nullable()->after('age_at_register');
            }
            if (!Schema::hasColumn('patients', 'remarks')) {
                $table->text('remarks')->nullable()->after('allegics');
            }
            if (!Schema::hasColumn('patients', 'basic_ilness')) {
                $table->text('basic_ilness')->nullable()->after('remarks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['allegics', 'remarks', 'basic_ilness']);
        });
    }
};
