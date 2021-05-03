<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTugasTanggalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas_tanggal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('surat_tugas_id')->nullable()->unsigned();
            $table->foreign('surat_tugas_id')->references('id')->on('surat_tugas')->onDelete('CASCADE');
            $table->date('tanggal')->nullable();
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
        Schema::dropIfExists('surat_tugas_tanggal');
    }
}
