<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipeMesinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_tipe_mesin', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenis_id')->nullable()->unsigned();
            $table->foreign('jenis_id')->references('id')->on('hd_jenis_mesin')->onDelete('CASCADE');
            $table->string('tipe')->nullable();
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
        Schema::dropIfExists('tipe_mesin');
    }
}
