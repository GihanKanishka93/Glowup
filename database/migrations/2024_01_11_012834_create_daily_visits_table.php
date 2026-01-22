<?php

use App\Models\User;
use App\Models\admission;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_visits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime('visit_time')->nullable();
            $table->text('description')->nullable();
            $table->foreignIdFor(User::class)->constrained('users');
           // $table->foreignIdFor(admission::class)->constrained('admitions');
            $table->bigInteger('admission_id')->nullable()->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_visits');
    }
};
