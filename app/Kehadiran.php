<?php

namespace App;

use App\PresensiGuru;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran'; 
    protected $fillable = [
        'id_pegawai', 'kehadiran'
    ];

    public function pegawai()
    {
        return $this->belongsTo(TbPegawai::class, 'id_pegawai', 'id_pegawai');
    }
    public function presensiGuru()
    {
        return $this->hasMany(PresensiGuru::class, 'id_kehadiran', 'id_kehadiran');
    }
}
