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
           // $table->uuid('category_uuid')->comment('FK categories.uuid');
            $table->foreignUuid('category_uuid');
           // ->nullable();
            //->references('uuid')
           // ->on('categories')
           // ->onDelete('cascade');
            $table->uuid('uuid');
            $table->string('title');
            $table->float('price');
            $table->text('description');
            $table->json('meta');
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
