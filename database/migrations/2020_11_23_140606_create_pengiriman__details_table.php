<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengirimanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_detail_kiriman', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('header_id')->unsigned()->nullable();
            $table->foreign('header_id')->references('id')->on('hd_pengiriman_header')->onDelete('CASCADE');
            $table->integer('jenis_id')->nullable()->unsigned();
            $table->foreign('jenis_id')->references('id')->on('hd_jenis_mesin')->onDelete('CASCADE');
            $table->integer('tipe_id')->nullable()->unsigned();
            $table->foreign('tipe_id')->references('id')->on('hd_tipe_mesin')->onDelete('CASCADE');
            $table->string('nomor')->nullable();
            $table->smallInteger('kondisi')->default(1);
            $table->integer('gudang_id')->unsigned()->nullable();
            $table->foreign('gudang_id')->references('id')->on('ba_gudang_alamat')->onDelete('CASCADE');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('tam_ba_rs')->onDelete('CASCADE');
            $table->smallInteger('akuisisi')->default(1);
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
        Schema::dropIfExists('hd_detail_kiriman');
    }
}
