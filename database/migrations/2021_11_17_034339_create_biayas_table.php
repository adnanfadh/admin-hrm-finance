<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biayas', function (Blueprint $table) {
            $table->id();
            $table->integer('account_pembayar')->nullable();
            $table->string('bayar_nanti')->nullable();
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->integer('syarat_pembayaran')->nullable();
            $table->integer('penerima_supplier')->nullable();
            $table->integer('penerima_pegawai')->nullable(); 
            $table->date('tanggal_transaksi');
            $table->string('transaksi');
            $table->string('no_biaya');
            $table->integer('metode_pembayaran')->nullable();
            $table->text('alamat_penagihan');
            $table->text('memo')->nullable();
            $table->string('lampiran')->nullable();
            $table->bigInteger('sub_total');
            $table->bigInteger('total');
            $table->integer('akun_pemotong')->nullable();
            $table->bigInteger('besar_potongan')->nullable();
            $table->bigInteger('grand_total');
            $table->bigInteger('sisa_tagihan');
            $table->string('category');
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
        Schema::dropIfExists('biayas');
    }
}
