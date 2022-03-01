<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('category_uuid')->comment('FK categories.uuid');
            $table->foreign('category_uuid')
            ->nullable()
            ->references('uuid')
            ->on('categories')
            ->onDelete('cascade');
            $table->string('uuid')->comment('UUID to allow easy migration between envs without breaking FK in the logic');
            $table->string('title');
            $table->float('price');
            $table->text('description');
            $table->json('meta')->comment('Example of the base content, can grow on demand.
            {
              "brand": "UUID from petshop.brands",
              "image": "UUID from petshop.files"
            }');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
