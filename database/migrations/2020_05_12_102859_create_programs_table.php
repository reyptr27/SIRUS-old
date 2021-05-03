<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_document');
            $table->integer('pemohon_id')->unsigned()->nullable();
            $table->foreign('pemohon_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('kadept_id')->unsigned()->nullable();
            $table->foreign('kadept_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->smallInteger('jenis')->nullable();
            $table->text('program')->nullable();
            $table->text('alasan')->nullable();
            $table->integer('officer_id')->unsigned()->nullable();
            $table->foreign('officer_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('verivikasi_it')->nullable();
            $table->integer('improvement_id')->unsigned()->nullable();
            $table->foreign('improvement_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->text('verivikasi_oi')->nullable();
            $table->smallInteger('hasil')->nullable();
            $table->smallInteger('approval')->nullable();
            $table->text('catatan_om')->nullable();
            $table->text('catatan_bom')->nullable();
            $table->integer('created_by')->nullable()->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('updated_by')->nullable()->unsigned();
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
        Schema::dropIfExists('program');
    }
}
