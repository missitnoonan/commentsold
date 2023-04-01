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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned();
            $table->text('street_address')->nullable();
            $table->text('apartment')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('country_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('order_status')->nullable();
            $table->string('payment_ref')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('payment_amt_cents')->nullable();
            $table->integer('ship_charged_cents')->nullable();
            $table->integer('ship_cost_cents')->nullable();
            $table->integer('subtotal_cents')->nullable();
            $table->integer('total_cents')->nullable();
            $table->text('shipper_name')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('shipped_date')->nullable();
            $table->text('tracking_number')->nullable();
            $table->integer('tax_total_cents')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
