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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('bill_id')->unique();
            $table->integer('amount');
            $table->string('service');
            $table->string('category');
            $table->string('comment')->nullable();
            $table->string('status');
            $table->integer('is_archive')->default(0);
            $table->timestamp('ordered_at');
            $table->timestamp("created_at");
            $table->timestamp("updated_at");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};