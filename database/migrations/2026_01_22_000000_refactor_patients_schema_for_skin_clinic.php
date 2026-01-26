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
            // Add new Client fields
            $table->string('nic', 20)->nullable()->after('name');
            $table->string('mobile_number', 20)->nullable()->after('nic');
            $table->string('whatsapp_number', 20)->nullable()->after('mobile_number');
            $table->string('email', 100)->nullable()->after('whatsapp_number');
            $table->string('address', 255)->nullable()->after('email');
            $table->string('occupation', 100)->nullable()->after('address');
            $table->string('referral_source', 100)->nullable()->after('occupation');

            // Drop Legacy Human Hospital columns
            $table->dropColumn([
                'father_contact2',
                'mother_contact2',
                'monthly_family_income',
                'monthly_loan_diductions',
                'transport_mode',
                'cost_of_travel',
                'financial_support',
                'wdu_reside'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Add back legacy columns (nullable to avoid issues)
            $table->string('father_contact2', 10)->nullable();
            $table->string('mother_contact2', 10)->nullable();
            $table->decimal('monthly_family_income', 10, 2)->nullable();
            $table->decimal('monthly_loan_diductions', 10, 2)->nullable();
            $table->string('transport_mode', 255)->nullable();
            $table->decimal('cost_of_travel', 10, 2)->nullable();
            $table->string('financial_support', 255)->nullable();
            $table->string('wdu_reside', 255)->nullable();

            // Drop new Client fields
            $table->dropColumn([
                'nic',
                'mobile_number',
                'whatsapp_number',
                'email',
                'address',
                'occupation',
                'referral_source'
            ]);
        });
    }
};
