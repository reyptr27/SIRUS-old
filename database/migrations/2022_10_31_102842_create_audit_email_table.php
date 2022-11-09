<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_email', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('nama')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->integer('dept_id')->nullable()->unsigned();
            $table->foreign('dept_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
            $table->integer('lokasi_id')->nullable()->unsigned();
            $table->foreign('lokasi_id')->references('id')->on('audit_lokasi')->onDelete('CASCADE');          
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
        Schema::dropIfExists('audit_email');
    }
}
