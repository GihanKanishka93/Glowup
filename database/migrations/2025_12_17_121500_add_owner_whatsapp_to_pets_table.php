<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->string('owner_whatsapp', 25)->nullable()->after('owner_contact');
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn('owner_whatsapp');
        });
    }
};
