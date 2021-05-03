<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenerimaanHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_penerimaan_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gudang_id')->unsigned()->nullable();
            $table->foreign('gudang_id')->references('id')->on('ba_gudang_alamat')->onDelete('CASCADE');
            $table->integer('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('tam_ba_rs')->onDelete('CASCADE');
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
        Schema::dropIfExists('hd_penerimaan_header');
    }
}
