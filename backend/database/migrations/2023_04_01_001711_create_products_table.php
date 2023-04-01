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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->text('description')->nullable();
            $table->text('style')->nullable();
            $table->text('brand')->nullable();
            $table->timestamps();
            $table->string('url')->nullable();
            $table->string('product_type')->nullable();
            $table->integer('shipping_price')->nullable();
            $table->text('note')->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();

            $table->foreign('admin_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
