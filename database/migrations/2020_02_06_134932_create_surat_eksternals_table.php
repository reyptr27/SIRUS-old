<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratEksternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_eksternals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tujuan_id')->unsigned()->nullable();
            $table->foreign('tujuan_id')->references('id')->on('tujuan_eksternal')->onDelete('CASCADE');
            $table->integer('dept_id')->unsigned()->nullable();
            $table->foreign('dept_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
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
        Schema::dropIfExists('surat_eksternals');
    }
}
