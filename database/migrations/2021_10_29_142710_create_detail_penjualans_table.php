<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->integer('penjualan_id');
            $table->integer('product_id');
            $table->integer('qty_pembelian');
            $table->integer('discount')->nullable();
            $table->bigInteger('besar_discount')->nullable();
            $table->integer('pajak_id')->nullable();
            $table->bigInteger('potongan_pajak')->nullable();
            $table->bigInteger('total');
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
        Schema::dropIfExists('detail_penjualans');
    }
}
