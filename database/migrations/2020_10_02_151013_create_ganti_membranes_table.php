<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGantiMembranesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tam_ba_ganti_membrane', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor');
            $table->date('tanggal');
            $table->integer('rs_id')->unsigned()->nullable();
            $table->foreign('rs_id')->references('id')->on('tam_ba_rs')->onDelete('CASCADE');
            $table->integer('jumlah')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('teknisi_id')->unsigned()->nullable();
            $table->foreign('teknisi_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('katek_id')->unsigned()->nullable();
            $table->foreign('katek_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('katam_id')->unsigned()->nullable();
            $table->foreign('katam_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('tam_ba_ganti_membrane');
    }
}
