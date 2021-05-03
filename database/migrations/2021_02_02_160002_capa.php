<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Capa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor')->nullable();
            $table->integer('kepada_id')->nullable()->unsigned();
            $table->foreign('kepada_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
            $table->integer('dari_id')->nullable()->unsigned();
            $table->foreign('dari_id')->references('id')->on('m_departemen')->onDelete('CASCADE');
            $table->integer('lokasi_id')->nullable()->unsigned();
            $table->foreign('lokasi_id')->references('id')->on('capa_lokasi')->onDelete('CASCADE');
            $table->date('tgl_terjadi')->nullable();
            $table->text('inti_masalah')->nullable();
            $table->text('rincian_masalah')->nullable();
            $table->text('penyebab_masalah')->nullable();
            $table->smallInteger('kategori_1')->default(1);
            $table->smallInteger('kategori_2')->default(1);
            $table->smallInteger('kategori_3')->default(1);
            $table->text('koreksi')->nullable();
            $table->text('pencegahan')->nullable();
            $table->date('tgl_target')->nullable();
            $table->integer('pic_id')->nullable()->unsigned();
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('tembusan_1')->nullable();
            $table->string('tembusan_2')->nullable();
            $table->text('hasil_tindakan')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->tinyInteger('all_dept')->default(0);
            $table->smallInteger('status')->default(1);
            $table->smallInteger('delete_status')->default(1);
            $table->text('delete_reason')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->string('upload_file')->nullable();
            $table->integer('uploaded_by')->nullable()->unsigned();
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->datetime('uploaded_at')->nullable();
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
        Schema::dropIfExists('capa');
    }
}
