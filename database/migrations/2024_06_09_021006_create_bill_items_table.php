<?php

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
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('bill_id')->nullable()->unsigned();
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->date('billing_date')->nullable();
            $table->string('item_name', 255)->nullable();
            $table->string('item_qty', 255)->nullable();
            $table->string('unit_price', 255)->nullable();
            $table->string('tax', 255)->nullable();
            $table->string('total_price', 255)->nullable();
            $table->string('note', 255)->nullable();
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
        Schema::dropIfExists('bill_items');
    }
};