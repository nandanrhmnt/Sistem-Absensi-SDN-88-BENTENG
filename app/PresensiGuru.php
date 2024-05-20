<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresensiGuru extends Model
{
    protected $table = 'presensi_guru';
    protected $primaryKey = 'id_presensi'; 
    protected $fillable = [
        'id_pegawai', 'id_kehadiran', 'tanggal', 'jam_masuk',  
    ];

    public function pegawai()
    {
        return $this->belongsTo(TbPegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function kehadiran()
    {
        return $this->belongsTo(Kehadiran::class, 'id_kehadiran', 'id_kehadiran');
    }
}
