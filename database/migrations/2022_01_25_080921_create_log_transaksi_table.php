<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_transaksi', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_id');
            $table->integer('transaksi_key');
            $table->integer('account_bank_id')->nullable();
            $table->bigInteger('saldo_awal')->nullable();
            $table->bigInteger('saldo_akhir')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('stock_awal')->nullable();
            $table->integer('stock_akhir')->nullable();
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
        Schema::dropIfExists('log_transaksi');
    }
}
