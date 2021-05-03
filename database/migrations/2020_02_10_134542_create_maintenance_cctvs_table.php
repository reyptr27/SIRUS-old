<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaintenanceCctvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_cctv', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('no_document');
            $table->string('nama_server');
            $table->string('lokasi');
            $table->integer('officer_id')->nullable()->unsigned();
            $table->foreign('officer_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->date('tanggal');
            $table->smallInteger('status');            
            $table->string('catatan')->nullable();

            $table->smallInteger('status1');
            $table->string('tindakan1')->nullable();
            
            $table->smallInteger('status2');
            $table->string('tindakan2')->nullable();
            
            $table->smallInteger('status3');
            $table->string('tindakan3')->nullable();
           
            $table->smallInteger('status4');
            $table->string('tindakan4')->nullable();
           
            $table->smallInteger('status5');
            $table->string('tindakan5')->nullable();
           
            $table->smallInteger('status6');
            $table->string('tindakan6')->nullable();
           
            $table->smallInteger('status7');
            $table->string('tindakan7')->nullable();
        
            $table->smallInteger('status8');
            $table->string('tindakan8')->nullable();
           
            $table->smallInteger('status9');
            $table->string('tindakan9')->nullable();
           
            $table->smallInteger('status10');
            $table->string('tindakan10')->nullable();
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
        Schema::dropIfExists('maintenance_cctv');
    }
}
