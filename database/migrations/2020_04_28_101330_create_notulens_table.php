<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotulensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->nullable()->unsigned();
            $table->foreign('event_id')->references('id')->on('event')->onDelete('CASCADE');
            $table->integer('divisi_id')->nullable()->unsigned();
            $table->foreign('divisi_id')->references('id')->on('m_divisi')->onDelete('CASCADE');
            $table->boolean('kategori_1')->default(0);
            $table->boolean('kategori_2')->default(0);
            $table->boolean('kategori_3')->default(0);
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
        Schema::dropIfExists('notulen');
    }
}
