<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerbaikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl');
            $table->string('no_document');
            $table->integer('pengadaan_id')->unsigned()->nullable();
            $table->foreign('pengadaan_id')->references('id')->on('pengadaan')->onDelete('CASCADE');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('jenis_id')->unsigned()->nullable();
            $table->foreign('jenis_id')->references('id')->on('jenis_permintaan')->onDelete('CASCADE');            
            $table->integer('officer_id')->unsigned()->nullable();
            $table->foreign('officer_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('diskripsi')->nullable();
            $table->text('akibat')->nullable();
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
        Schema::dropIfExists('perbaikan');
    }
}
