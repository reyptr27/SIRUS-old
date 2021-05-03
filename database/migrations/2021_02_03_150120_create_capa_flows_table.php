<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapaFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa_flow', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('capa_id')->nullable()->unsigned();
            $table->foreign('capa_id')->references('id')->on('capa')->onDelete('CASCADE');
            $table->string('header')->nullable();
            $table->smallInteger('layer')->nullable();
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->smallInteger('status')->nullable();
            $table->datetime('time')->nullable();
            $table->smallInteger('upload')->default(0);
            $table->text('feedback')->nullable();
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
        Schema::dropIfExists('capa_flow');
    }
}
