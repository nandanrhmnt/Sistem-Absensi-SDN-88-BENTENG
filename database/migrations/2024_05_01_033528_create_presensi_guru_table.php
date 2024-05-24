<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresensiGuruTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presensi_guru', function (Blueprint $table) {
            $table->id('id_presensi')->autoIncrement();
            $table->unsignedBigInteger('id_pegawai');
            $table->unsignedBigInteger('id_kehadiran');
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->timestamps();
            $table->foreign('id_pegawai')->references('id_pegawai')->on('tb_pegawai')->onDelete('cascade');
            $table->foreign('id_kehadiran')->references('id_kehadiran')->on('kehadiran')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presensi_guru');
    }
}
