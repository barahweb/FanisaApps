<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->string('id_order')->unique();
            $table->integer('id_customer')->unsigned();
            $table->foreign('id_customer')->references('id_customer')->on('customers');
            $table->integer('status');
            $table->string('pdf')->nullable();
            $table->string('ongkir')->nullable();
            $table->string('ekspedisi')->nullable();
            $table->string('nomor_resi')->nullable();
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
        Schema::dropIfExists('carts');
    }
}
