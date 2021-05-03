<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArsipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenis_id')->nullable()->unsigned();
            $table->foreign('jenis_id')->references('id')->on('jenis_arsip')->onDelete('CASCADE');
            $table->string('nomor')->nullable();
            $table->year('tahun')->nullable();
            $table->string('nama_arsip')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tgl_arsip')->nullable();
            $table->string('upload_file')->nullable();
            $table->float('file_size')->nullable();
            $table->integer('jumlah_download')->nullable();
            $table->smallInteger('delete_status')->default(1);
            $table->integer('created_by')->nullable()->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('updated_by')->nullable()->unsigned();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('arsip');
    }
}
