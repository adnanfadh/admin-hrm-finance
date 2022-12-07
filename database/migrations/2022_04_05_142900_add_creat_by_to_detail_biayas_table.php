<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatByToDetailBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_biayas', function (Blueprint $table) {
            $table->integer('creat_by')->nullable();
            $table->integer('creat_by_company')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_biayas', function (Blueprint $table) {
            $table->dropColumn('creat_by')->nullable(false);
            $table->dropColumn('creat_by_company')->nullable(false);
        });
    }
}
