<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomingProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incoming_product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_incoming');
            $table->string('id_product');
            $table->integer('quantity');
            $table->string('description');
            $table->foreign('id_incoming')->references('id')->on('incoming_product')->onDelete('cascade');
            $table->foreign('id_product')->references('id_product')->on('product')->onDelete('cascade');
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
        Schema::dropIfExists('incoming_product_details');
    }
}
