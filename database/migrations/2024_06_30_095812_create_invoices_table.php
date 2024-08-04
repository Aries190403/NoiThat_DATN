<?php
// Migration for invoices table
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->date('invoice_date')->getdate();
            $table->string('address');
            $table->string('phone');
            $table->string('name');
            $table->decimal('total', 8, 2);
            $table->decimal('discountMoney', 8, 2);
            $table->string('status');
            $table->string('delivery');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons');
            $table->foreignId('pay_id')->constrained('pays');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
