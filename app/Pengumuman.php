<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = ['gambar','dokumen','isi','judul','start_pengumuman','stop_pengumuman'];
}
