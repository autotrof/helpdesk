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
}
