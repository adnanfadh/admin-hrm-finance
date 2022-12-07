<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJurnalEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnal_entri', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_id');
            $table->integer('account_id');
            $table->date('tanggal_transaksi');
            $table->bigInteger('debit');
            $table->bigInteger('kredit');
            $table->integer('category');
            $table->integer('tahapan');
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
        Schema::dropIfExists('jurnal_entri');
    }
}
