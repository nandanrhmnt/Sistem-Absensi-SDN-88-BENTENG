<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TbPegawai extends Model
{
    protected $table = 'tb_pegawai';
    protected $primaryKey = 'id_pegawai'; 
    protected $fillable = [
        'NIP', 'keterangan', 'Nama', 'jenis_kelamin', 'No_hp'
    ];
    public function presensi()
    {
        return $this->hasMany(PresensiGuru::class, 'id_pegawai', 'id_pegawai');
    }
}
