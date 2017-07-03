<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisLaporan extends Model
{
    protected $table = 'jenis_laporan';
    protected $fillable = ['kode','deskripsi'];

    public function listLaporan()
    {
    	return $this->hasMany('App\Laporan','jenis_laporan_id');
    }

    public function listSolvedLaporan()
    {
    	return $this->hasMany('App\Laporan','jenis_laporan_id')->where('status','Terselesaikan');
    }

    public function listUnSolvedLaporan()
    {
    	return $this->hasMany('App\Laporan','jenis_laporan_id')->where('status','Tidak Terselesaikan');
    }

    public function listProsesLaporan()
    {
    	return $this->hasMany('App\Laporan','jenis_laporan_id')->where('status','Proses');
    }

    public function listUnreadLaporan()
    {
    	return $this->hasMany('App\Laporan','jenis_laporan_id')->where('status','belum dibaca');
    }

    public function listOtherLaporan()
    {
    	return $this->hasMany('App\Laporan','jenis_laporan_id')->where('status','<>','Terselesaikan')->where('status','<>','Tidak Terselesaikan');
    }

}
