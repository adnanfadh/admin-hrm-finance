<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('transaksi');
            $table->string('no_transaksi');
            $table->integer('supplier_id');
            // $table->integer('account_bank_id');
            $table->date('tanggal_transaksi');
            $table->integer('metode_pembayaran_id');
            $table->integer('syarat_pembayaran_id');
            $table->date('tanggal_jatuh_tempo');
            $table->bigInteger('nominal_tagihan');
            $table->text('alamat_penagihan');
            $table->text('pesan')->nullable();
            $table->string('lampiran')->nullable();
            $table->bigInteger('sub_total');
            $table->integer('discount_pembelian')->nullable();
            $table->bigInteger('total');
            $table->bigInteger('sisa_tagihan'); 
            $table->integer('status');
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
        Schema::dropIfExists('pembelians');
    }
}
