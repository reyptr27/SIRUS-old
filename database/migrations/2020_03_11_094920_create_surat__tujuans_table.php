<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratTujuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_tugas_tujuan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('surat_tugas_id')->nullable()->unsigned();
            $table->foreign('surat_tugas_id')->references('id')->on('surat_tugas')->onDelete('CASCADE');
            $table->integer('tujuan_id')->nullable()->unsigned();
            $table->foreign('tujuan_id')->references('id')->on('tujuan_st')->onDelete('CASCADE');
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
        Schema::dropIfExists('surat_tugas_tujuan');
    }
}
