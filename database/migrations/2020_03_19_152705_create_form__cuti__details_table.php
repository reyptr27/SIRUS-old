<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormCutiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_cuti_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuti_id')->unsigned()->nullable();
            $table->foreign('cuti_id')->references('id')->on('hrd_cuti_header')->onDelete('CASCADE');
            $table->string('deskripsi')->nullable();
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('hrd_cuti_detail');
    }
}
