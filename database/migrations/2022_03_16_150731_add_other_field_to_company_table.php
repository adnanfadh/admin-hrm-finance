<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherFieldToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->string('website_company')->nullable();
            $table->integer('pemberi_wewenang1')->nullable();
            $table->integer('pemberi_wewenang2')->nullable();
            $table->integer('pemberi_wewenang3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('website_company')->nullable();
            $table->dropColumn('pemberi_wewenang1')->nullable();
            $table->dropColumn('pemberi_wewenang2')->nullable();
            $table->dropColumn('pemberi_wewenang3')->nullable();
        });
    }
}
