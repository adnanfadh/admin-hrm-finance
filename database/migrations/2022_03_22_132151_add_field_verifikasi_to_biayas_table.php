<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldVerifikasiToBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('biayas', function (Blueprint $table) {
            $table->boolean('verifikasi')->default(true);
            $table->integer('company_id');
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
            $table->dropColumn('verifikasi')->default(true);
            $table->dropColumn('company_id');
        });
    }
}
