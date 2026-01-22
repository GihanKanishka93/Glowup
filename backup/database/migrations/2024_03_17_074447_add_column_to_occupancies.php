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
        Schema::table('occupancies', function (Blueprint $table) {
            $table->bigInteger('created_by_user_id')->unsigned()->nullable();
            $table->bigInteger('updated_by_user_id')->unsigned()->nullable();
            $table->bigInteger('deleted_by_user_id')->unsigned()->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');
            $table->foreign('updated_by_user_id')->references('id')->on('users');
            $table->foreign('deleted_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('occupancies', function (Blueprint $table) {
            $table->dropColumn('created_by_user_id');
            $table->dropColumn('updated_by_user_id');
            $table->dropColumn('deleted_by_user_id');
        });
    }
};
