<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaporanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenis_laporan_id')->unsigned();
            $table->foreign('jenis_laporan_id')->references('id')->on('jenis_laporan')->onDelete('cascade');
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->string('nip_pelapor');
            $table->string('lokasi');
            $table->string('status')->default('belum dibaca');
            $table->string('dugaan')->nullable();
            $table->string('aksi')->nullable();
            $table->dateTime('waktu_melapor');
            $table->dateTime('waktu_dibaca');
            $table->dateTime('waktu_dugaan');
            $table->dateTime('waktu_aksi');
            $table->dateTime('waktu_final');
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
        Schema::drop('laporan');
    }
}
