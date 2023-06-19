<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampahs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kepala_keluarga');
            $table->integer('nomor_rumah');
            $table->string('rt_rw');
            $table->integer('total_karung_sampah');
            $table->enum('kriteria', ['standar', 'collapse']);
            $table->date('tanggal_pengangkutan');
            $table->softDeletes();
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
        Schema::dropIfExists('sampahs');
    }
}
