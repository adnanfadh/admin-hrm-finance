<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeQtyPembelianToDetailPembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->integer('product_id')->nullable()->change();
            $table->integer('qty_pembelian')->nullable()->change();
            $table->bigInteger('total')->nullable()->change(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_pembelians', function (Blueprint $table) {
            $table->integer('product_id')->nullable(false)->change();
            $table->integer('qty_pembelian')->nullable(false)->change();
            $table->bigInteger('total')->nullable(false)->change();
        });
    }
}
