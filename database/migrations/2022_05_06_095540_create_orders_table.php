<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('address_id')->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->tinyInteger('status')->default(0);
            $table->decimal('shipping_fee', 15, 2);
            $table->string('payment_method');
            $table->string('payment_signature')->nullable();
            $table->unsignedBigInteger('request_id')->nullable();
            $table->date('shipped_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
