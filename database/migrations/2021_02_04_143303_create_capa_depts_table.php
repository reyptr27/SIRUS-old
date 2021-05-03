<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapaDeptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa_dept', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('capa_id')->nullable()->unsigned();
            $table->foreign('capa_id')->references('id')->on('capa')->onDelete('CASCADE');
            $table->integer('dept_id')->nullable()->unsigned();
            $table->foreign('dept_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
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
        Schema::dropIfExists('capa_dept');
    }
}
