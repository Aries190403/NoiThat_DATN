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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_create')->nullable();
            $table->string('code', 255)->nullable();
            $table->integer('limit')->nullable();
            $table->integer('count_active')->nullable();
            $table->float('discount')->nullable();
            $table->float('discount_money');
            $table->timestamp('downtime')->nullable();
            $table->text('description')->nullable();
            $table->char('status', 50)->nullable();
            $table->timestamps();

            $table->foreign('user_create')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
