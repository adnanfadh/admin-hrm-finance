<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGajiSecondTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gaji_second', function (Blueprint $table) {
            $table->id();
            $table->integer('pegawai_id');
            $table->string('periode');
            $table->bigInteger('gaji_pokok');
            $table->bigInteger('tunjangan_kerajinan')->nullable();
            $table->bigInteger('tunjangan_makan')->nullable();
            $table->bigInteger('tunjangan_jabatan')->nullable();
            $table->bigInteger('lembur_harian')->nullable();
            $table->bigInteger('lembur_hari_libur')->nullable();
            $table->bigInteger('lembur_event')->nullable();
            $table->bigInteger('perjalanan_dinas')->nullable();
            $table->bigInteger('tunjangan_keluarga')->nullable();
            $table->bigInteger('biaya_jabatan')->nullable();
            $table->bigInteger('tabungan')->nullable();
            $table->bigInteger('bpjs_kesehatan')->nullable();
            $table->bigInteger('bpjs_ketenagakerjaan')->nullable();
            $table->bigInteger('potongan_lain_lain')->nullable();
            $table->bigInteger('pajak_21')->nullable();
            $table->bigInteger('total_penerimaan');
            $table->bigInteger('total_potongan')->nullable();
            $table->bigInteger('total_gaji_bersih');
            $table->integer('creat_by_company');
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
        Schema::dropIfExists('gaji_second');
    }
}
