<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $fillable = ['jenis_laporan_id','deskripsi','gambar','nip_pelapor','lokasi','status','dugaan','aksi','waktu_melapor','waktu_dibaca','waktu_dugaan','waktu_aksi','waktu_final'];

    public function jenisLaporanInfo()
    {
    	return $this->belongsTo('App\JenisLaporan','jenis_laporan_id');
    }
}
