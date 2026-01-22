<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reminder_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('send_vaccination')->default(true);
            $table->boolean('send_followup')->default(true);
            $table->json('lead_days')->nullable(); // store as ["1","3","7"]
            $table->string('from_email')->nullable();
            $table->string('from_name')->nullable();
            $table->string('reply_to')->nullable();
            $table->timestamps();
        });

        Schema::create('reminder_logs', function (Blueprint $table) {
            $table->id();
            $table->string('reminder_type'); // vaccination | next_clinic
            $table->unsignedBigInteger('pet_id')->nullable();
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->unsignedBigInteger('vaccination_info_id')->nullable();
            $table->string('owner_email')->nullable();
            $table->string('status')->default('sent'); // sent | failed
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['reminder_type', 'sent_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminder_logs');
        Schema::dropIfExists('reminder_settings');
    }
};
