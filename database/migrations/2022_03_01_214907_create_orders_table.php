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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('order_status_id')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->foreign('user_id')
            ->nullable()
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->foreign('order_status_id')
            ->nullable()
            ->references('id')
            ->on('order_statuses')
            ->onDelete('cascade');
            $table->foreign('payment_id')
            ->nullable()
            ->references('id')
            ->on('payments')
            ->onDelete('cascade');
            $table->uuid('uuid');
            $table->json('products');
            $table->json('address');
            $table->float('delivery_fee')->nullable();
            $table->float('amount');
            $table->timestamps();
            $table->timestamp('shipped_at')->nullable();
           
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
