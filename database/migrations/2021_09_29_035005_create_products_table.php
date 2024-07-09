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
            $table->increments('id_product');
            $table->Integer('id_kategori')->unsigned();
            $table->foreign('id_kategori')->references('id')->on('categories');
            $table->string('nama_barang');
            $table->double('harga');
            $table->string('jumlah');
            $table->string('berat');
            $table->Text('deskripsi')->nullable();
            $table->string('gambar');
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
