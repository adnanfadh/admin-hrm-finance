<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferUangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_uangs', function (Blueprint $table) {
            $table->id();
            $table->integer('account_transper');
            $table->integer('account_setor');
            $table->text('memo')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('transaksi');
            $table->string('no_transaksi');
            $table->date('tanggal_transaksi');
            $table->bigInteger('jumlah');
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
        Schema::dropIfExists('transfer_uangs');
    }
}
