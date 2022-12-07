<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan_pembelians', function (Blueprint $table) {
            $table->id();
            $table->integer('pembelian_id');
            $table->date('tanggal_bayar');
            $table->integer('account_pembayar');
            $table->bigInteger('nominal_pembayaran');
            $table->string('transaksi');
            $table->string('no_pembayaran');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('tagihan_pembelians');
    }
}
