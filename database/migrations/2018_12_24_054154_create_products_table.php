<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('title');  // не пустой, уникальный
            $table->decimal('price', 8, 2);  // не пустая, не нулевая, не меньше нуля, число
			$table->integer('category_id');  // должна существовать
			$table->string('article');  // не пустой, уникальный
			$table->string('brand')->default('No brand');
			$table->string('image')->nullable();
			$table->text('description')->nullable();
			$table->integer('is_new')->default(0);  // пустое, 0 или 1
			$table->integer('is_recommended')->default(0);  // пустое, 0 или 1
			$table->integer('status')->default(1);  // пустое, 0 или 1
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
        Schema::dropIfExists('products');
    }
}
