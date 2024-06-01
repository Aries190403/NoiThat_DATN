<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('role', 50)->nullable();
            $table->string('name', 255);
            $table->string('password', 255);
            $table->char('phone', 20)->nullable();
            $table->string('email', 255)->unique();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('avatar')->nullable();
            $table->char('locked', 50)->nullable();
            $table->char('status', 50)->nullable();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('avatar')->references('id')->on('pictures')->onDelete('cascade');
        });

        DB::table('users')->insert([
            'role' => 'ROLE_SUPER_ADMIN',
            'name' => 'Admin',
            'phone' => null,
            'email' => 'admin@example.com',
            'address_id' => null,
            'avatar' => null,
            'locked' => 'normal',
            'status' => 'active',
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

