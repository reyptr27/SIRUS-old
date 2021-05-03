<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeknisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tam_teknisi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teknisi_id')->unsigned()->nullable();
            $table->foreign('teknisi_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->smallInteger('status')->default(1);
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
        Schema::dropIfExists('tam_teknisi');
    }
}
