<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapaFlowTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa_flow_template', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('auth_id')->nullable()->unsigned();
            $table->foreign('auth_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('nama_template')->nullable();
            $table->string('header')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
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
        Schema::dropIfExists('capa_flow_template');
    }
}
