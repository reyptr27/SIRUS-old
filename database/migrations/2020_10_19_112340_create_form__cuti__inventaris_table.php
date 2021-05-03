<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormCutiInventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrd_cuti_inventaris', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jenis_kendaraan')->nullable();
            $table->string('nomor_kendaraan')->nullable();
            $table->smallInteger('kunci_stnk')->default(1);
            $table->date('tgl_serah')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->string('lokasi_serah')->nullable();
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
        Schema::dropIfExists('hrd_cuti_inventaris');
    }
}
