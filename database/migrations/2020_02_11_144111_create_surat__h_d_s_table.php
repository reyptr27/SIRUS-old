<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratHDSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_hd', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tujuan_id')->unsigned()->nullable();
            $table->foreign('tujuan_id')->references('id')->on('tujuan_hd')->onDelete('CASCADE');
            $table->integer('kategori_id')->unsigned()->nullable();
            $table->foreign('kategori_id')->references('id')->on('kategori_hd')->onDelete('CASCADE');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('surat_hd');
    }
}
