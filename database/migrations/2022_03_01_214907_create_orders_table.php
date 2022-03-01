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
            $table->timestamps();
            $table->string('uuid')->comment('UUID to allow easy migration between envs without breaking FK in the logic');
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
