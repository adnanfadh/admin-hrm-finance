<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_penjualans', function (Blueprint $table) {
            $table->id();
            $table->Integer('penjualan_id');
            $table->date('tanggal_bayar');
            $table->integer('account_pembayar');
            $table->bigInteger('nominal_pembayaran');
            $table->string('transaksi');
            $table->string('no_pembayaran');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('tagihan_penjualans');
    }
}
