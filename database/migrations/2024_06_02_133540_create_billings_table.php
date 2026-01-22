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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('billing_id', 255);
            $table->bigInteger('treatment_id')->nullable()->unsigned();
            $table->foreign('treatment_id')->references('id')->on('treatments');
            $table->date('billing_date')->nullable();
            $table->tinyInteger('payment_status')->nullable();
            $table->string('note', 255)->nullable();
            $table->string('total', 255)->nullable();
            $table->string('discount', 255)->nullable();
            $table->string('tax_amount', 255)->nullable();
            $table->string('net_amount', 255)->nullable();
            $table->string('payment_type', 255)->nullable();
            $table->string('payment_note', 255)->nullable();
            $table->softDeletes();
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};