<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_banks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomor');
            $table->string('category');
            $table->string('details');
            $table->unsignedBigInteger('pajak_id');
            $table->foreign('pajak_id')->references('id')->on('pajaks')->onDelete('CASCADE');
            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->bigInteger('saldo')->nullable();
            $table->text('deskripsi');
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
        Schema::dropIfExists('account_banks');
    }
}
