<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pelaksanaan');
            $table->string('item');
            $table->integer('jumlah_item')->nullable();
            $table->integer('jumlah_item_approved')->nullable();
            $table->bigInteger('budget');
            $table->bigInteger('budget_approved')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('detail_pengajuan');
    }
}
