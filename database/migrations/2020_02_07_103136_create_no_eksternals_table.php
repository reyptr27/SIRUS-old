<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoEksternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('no_eksternal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_eksternal');
            $table->integer('dept_id')->nullable()->unsigned();
            $table->foreign('dept_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
            $table->integer('cabang_id')->nullable()->unsigned();
            $table->foreign('cabang_id')->references('id')->on('m_cabang')->onDelete('CASCADE');
            $table->string('tgl')->nullable();
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
        Schema::dropIfExists('no_eksternal');
    }
}
