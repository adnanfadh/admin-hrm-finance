<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->integer('jenis_pengajuan');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_approved')->nullable();
            $table->integer('penerima');
            $table->string('no_surat');
            $table->string('perihal_surat');
            $table->string('lampiran_surat');
            $table->bigInteger('total_nominal_pengajuan');
            $table->integer('status_pengajuan');
            $table->integer('creat_by');
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
        Schema::dropIfExists('pengajuan');
    }
}
