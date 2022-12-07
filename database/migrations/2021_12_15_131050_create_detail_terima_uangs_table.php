<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailTerimaUangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_terima_uangs', function (Blueprint $table) {
            $table->id();
            $table->integer('terima_uangs_id');
            $table->integer('akun_pengirim');
            $table->string('deskripsi');
            $table->integer('pajak_id')->nullable();
            $table->bigInteger('potongan_pajak')->nullable();
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
        Schema::dropIfExists('detail_terima_uangs');
    }
}
