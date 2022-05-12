<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_terima')->nullable();
            $table->string('nomor')->nullable();
            $table->string('nomor_eksternal')->nullable();
            $table->date('tgl_eksternal')->nullable();
            $table->text('hal')->nullable();
            $table->integer('up_id')->unsigned()->nullable();
            $table->foreign('up_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('dept_id')->unsigned()->nullable();
            $table->foreign('dept_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('upload_file')->nullable();
            $table->smallInteger('tindakan')->nullable()->comment('1:dibaca | 2:dibalas');
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
        Schema::dropIfExists('surat_masuk');
    }
}
