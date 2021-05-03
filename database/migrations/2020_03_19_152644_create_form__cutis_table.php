<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormCutisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_cuti_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('karyawan_id')->unsigned()->nullable();
            $table->foreign('karyawan_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->date('tanggal_bergabung')->nullable();
            $table->date('tanggal_awal')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->string('alasan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_telp',13)->nullable();
            $table->smallInteger('jenis_cuti')->nullable();
            $table->integer('pengganti_id')->unsigned()->nullable();
            $table->foreign('pengganti_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('controller_id')->unsigned()->nullable();
            $table->foreign('controller_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('hrd_cuti_header');
    }
}
