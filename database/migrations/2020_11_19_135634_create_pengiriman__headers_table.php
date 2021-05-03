<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengirimanHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hd_pengiriman_header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nomor')->nullable();
            $table->integer('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('tam_ba_rs')->onDelete('CASCADE');
            $table->date('tgl_approval')->nullable();
            $table->date('tgl_plan_kirim')->nullable();
            $table->date('tgl_plan_instalasi')->nullable();
            $table->date('tgl_kirim')->nullable();
            $table->date('tgl_instalasi')->nullable();
            $table->date('tgl_bast')->nullable();
            $table->string('upload_file')->nullable();
            $table->integer('status')->default(1);
            $table->smallInteger('delete_status')->default(1);
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
        Schema::dropIfExists('hd_pengiriman_header');
    }
}
