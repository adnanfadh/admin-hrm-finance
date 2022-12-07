<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitToPesertaPonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_2')->table('peserta_pons', function (Blueprint $table) {
            $table->string('jam_keberangkatan');
            $table->string('tipe_kendaraan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_2')->table('peserta_pons', function (Blueprint $table) {
            $table->dropColumn('jam_keberangkatan');
            $table->dropColumn('tipe_kendaraan');
        });
    }
}
