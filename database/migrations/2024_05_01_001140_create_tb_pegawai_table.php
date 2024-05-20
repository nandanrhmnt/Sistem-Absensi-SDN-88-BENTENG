<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pegawai', function (Blueprint $table) {
            $table->bigIncrements('id_pegawai');
            $table->string('NIP', 25)->nullable();
            $table->enum('keterangan', ['guru', 'honorer']);
            $table->string('Nama', 40);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('No_hp', 15);
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
        Schema::dropIfExists('tb_pegawai');
    }
}