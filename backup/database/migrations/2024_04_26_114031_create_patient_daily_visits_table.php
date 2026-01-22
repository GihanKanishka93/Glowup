<?php
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_daily_visits', function (Blueprint $table) {
            $table->id(); 
            $table->timestamps(); 
            $table->softDeletes(); 
 
            $table->dateTime('visit_time')->nullable(); 
            $table->longText('description')->nullable();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade'); 
            $table->bigInteger('patient_id')->nullable()->unsigned(); 
            // New fields
            $table->longText('family_history')->nullable(); 
            $table->longText('economic_status')->nullable();
            $table->longText('social_history')->nullable();
            $table->longText('remark')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_daily_visits'); 
    }
};
