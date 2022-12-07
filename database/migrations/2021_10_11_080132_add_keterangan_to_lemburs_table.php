<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKeteranganToLembursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lemburs', function (Blueprint $table) {
            $table->time('jam_masuk_lembur');
            $table->time('jam_keluar_lembur');
            $table->string('pekerjaan');
            $table->string('uraian_pekerjaan');
            $table->integer('status_lembur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lemburs', function (Blueprint $table) {
            $table->dropColumn('jam_masuk_lembur');
            $table->dropColumn('jam_keluar_lembur');
            $table->dropColumn('pekerjaan');
            $table->dropColumn('uraian_pekerjaan');
            $table->dropColumn('status_lembur');
        });
    }
}
