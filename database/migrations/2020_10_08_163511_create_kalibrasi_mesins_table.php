<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKalibrasiMesinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tam_ba_kalibrasi_mesin', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('kalibrasi_id')->nullable()->unsigned();
            $table->foreign('kalibrasi_id')->references('id')->on('tam_ba_kalibrasi')->onDelete('CASCADE');
            $table->string('merk')->nullable();
            $table->string('no_seri')->nullable();           
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
        Schema::dropIfExists('tam_ba_kalibrasi_mesin');
    }
}
