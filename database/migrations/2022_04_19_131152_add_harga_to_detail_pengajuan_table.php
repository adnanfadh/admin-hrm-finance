<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHargaToDetailPengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pengajuan', function (Blueprint $table) {
            $table->bigInteger('harga');
            $table->integer('id_pengajuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pengajuan', function (Blueprint $table) {
            $table->dropColumn('harga');
            $table->dropColumn('id_pengajuan');
        });
    }
}
