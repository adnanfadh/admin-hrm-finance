<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNominaltagihanFieldAtPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->bigInteger('nominal_tagihan')->nullable()->change();
            $table->bigInteger('sisa_tagihan')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penjualans', function (Blueprint $table) {
            $table->bigInteger('nominal_tagihan')->nullable(false)->change();
            $table->bigInteger('sisa_tagihan')->nullable(false)->change();
        });
    }
}
