<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaGudangBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_gudang_barang', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('ba_gudang_id')->nullable()->unsigned();
            $table->foreign('ba_gudang_id')->references('id')->on('ba_gudang')->onDelete('CASCADE');
            $table->string('nama_barang')->nullable();
            $table->integer('kuantitas')->nullable();
            $table->string('satuan')->nullable();
            $table->smallInteger('kondisi')->nullable();
            $table->string('keterangan')->nullable();           
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
        Schema::dropIfExists('ba_gudang_barang');
    }
}
