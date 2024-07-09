<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pembelians', function (Blueprint $table) {
            $table->string('id_detail_pembelian')->primary();
            $table->unsignedInteger('id_pembelian')->nullable();
            $table->foreign('id_pembelian')->references('id_pembelian')->on('pembelians');
            $table->unsignedInteger('id_product');
            $table->foreign('id_product')->references('id_product')->on('products');
            $table->double('harga');
            $table->string('jumlah');
            $table->integer('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_pembelians');
    }
}
