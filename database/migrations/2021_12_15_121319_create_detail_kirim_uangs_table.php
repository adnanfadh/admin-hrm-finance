<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKirimUangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_kirim_uangs', function (Blueprint $table) {
            $table->id();
            $table->integer('kirim_uangs_id');
            $table->integer('akun_tujuan');
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
        Schema::dropIfExists('detail_kirim_uangs');
    }
}
