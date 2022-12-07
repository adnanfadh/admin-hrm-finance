<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pengajuan');
            $table->dateTime('tanggal_action');
            $table->integer('user_action');
            $table->string('keterangan_track');
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
        Schema::dropIfExists('track_pengajuan');
    }
}
