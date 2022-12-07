<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMetodePembayaranFieldAtBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biayas', function (Blueprint $table) {
            $table->integer('metode_pembayaran')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('biayas', function (Blueprint $table) {
            $table->integer('metode_pembayaran')->nullable(false)->change();
        });
    }
}
