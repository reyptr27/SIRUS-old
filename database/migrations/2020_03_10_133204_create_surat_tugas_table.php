<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor_surat');
            $table->string('jabatan')->nullable();
            $table->string('nomor_polisi')->nullable();
            $table->string('kegiatan');
            $table->date('tanggal_tugas');
            $table->date('tanggal_akhir');
            $table->integer('status_ttd');
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
        Schema::dropIfExists('surat_tugas');
    }
}
