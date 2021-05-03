<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotulenDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulen_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notulen_id')->nullable()->unsigned();
            $table->foreign('notulen_id')->references('id')->on('notulen')->onDelete('CASCADE');
            $table->text('deskripsi')->nullable();
            $table->integer('dept_id')->nullable()->unsigned();
            $table->foreign('dept_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
            $table->date('tgl_target')->nullable();
            $table->text('realisasi')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('notulen_detail');
    }
}
