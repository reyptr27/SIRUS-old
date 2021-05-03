<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockMesinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_stock_mesin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipe_id')->nullable()->unsigned();
            $table->foreign('tipe_id')->references('id')->on('hd_tipe_mesin')->onDelete('CASCADE');
            $table->string('nomor')->nullable();
            $table->smallInteger('kondisi')->default(1);
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('hd_stock_mesin');
    }
}
