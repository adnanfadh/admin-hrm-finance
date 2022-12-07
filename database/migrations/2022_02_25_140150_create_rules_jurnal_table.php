<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRulesJurnalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules_jurnal', function (Blueprint $table) {
            $table->id();
            $table->integer('rules_jurnal_category');
            $table->integer('rules_jurnal_category_2');
            $table->string('rules_jurnal_name');
            $table->text('rules_jurnal_keterangan')->nullable();
            $table->integer('rules_jurnal_akun_debit')->nullable();
            $table->integer('rules_jurnal_akun_kredit')->nullable();
            $table->integer('rules_jurnal_akun_discount')->nullable();
            $table->integer('rules_jurnal_akun_ppn')->nullable();
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
        Schema::dropIfExists('rules_jurnal');
    }
}
