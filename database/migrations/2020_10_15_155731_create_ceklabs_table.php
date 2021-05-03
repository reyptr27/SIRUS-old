<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCeklabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tam_ceklab', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor');
            $table->integer('rs_id')->unsigned()->nullable();
            $table->foreign('rs_id')->references('id')->on('tam_ba_rs')->onDelete('CASCADE');
            $table->string('type');
            $table->string('alamat');
            $table->integer('pemohon_id')->unsigned()->nullable();
            $table->foreign('pemohon_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('pemeriksaan');
            $table->integer('pihak_ketiga');
            $table->string('lainnya')->nullable();
            $table->string('upload_file')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists('tam_ceklab');
    }
}
