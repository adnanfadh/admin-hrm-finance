<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaPonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_2')->create('peserta_pons', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peserta');
            $table->string('name');
            $table->string('destinasi');
            $table->string('kontingen');
            $table->string('cabor');
            $table->date('tgl_pcr');
            $table->date('tgl_keberangkatan');
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
        Schema::connection('mysql_2')->dropIfExists('peserta_pons');
    }
}


// id
// kode_peserta
// name
// destinasi
// kontingen
// cabor
// tgl_pcr
// tgl_keberangkatan
