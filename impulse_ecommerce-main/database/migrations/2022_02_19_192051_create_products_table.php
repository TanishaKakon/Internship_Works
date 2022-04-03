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
            $table->string('title');
            $table->string('slug');
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->string('size')->default('M');
            $table->enum('condition', ['default', 'new','hot'])->default('default');
            $table->enum('status', ['active', 'inactive',])->default('inactive');
            $table->double('price', 8, 2);
            $table->double('discount', 8, 2);
            $table->tinyInteger('is_featured');
            $table->bigInteger('cat_id')->nullable();
            $table->bigInteger('child_cat_id')->nullable();
            $table->bigInteger('brand_id')->nullable();
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
