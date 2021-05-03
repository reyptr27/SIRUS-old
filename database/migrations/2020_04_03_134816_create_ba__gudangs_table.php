<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_gudang', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_document');
            $table->date('tanggal');
            $table->integer('penerima_id')->unsigned()->nullable();
            $table->foreign('penerima_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('alamat_penerima')->nullable();
            $table->string('nama_pengirim')->nullable();
            $table->string('perusahaan_pengirim')->nullable();
            $table->string('alamat_pengirim')->nullable();
            $table->string('jenis_barang')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('no_container')->nullable();
            $table->string('no_seal')->nullable();
            $table->string('no_surat_jalan')->nullable();
            $table->smallInteger('sesuai')->nullable();
            $table->integer('selisih')->nullable();
            $table->integer('cacat')->nullable();
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
        Schema::dropIfExists('ba_gudang');
    }
}
