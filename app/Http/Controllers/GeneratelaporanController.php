<?php

namespace App\Http\Controllers;

use App\Kehadiran;
use App\TbPegawai;
use App\PresensiGuru;
use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneratelaporanController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Ambil data dari request
        $id_pegawai = $request->input('id');
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');

        // Query untuk mendapatkan data pegawai dan kehadiran sesuai tanggal
        $pegawai = TbPegawai::where('id_pegawai', $id_pegawai)->get();
        $data = [];
        foreach ($pegawai as $key => $value) {
            $hadir = PresensiGuru::where(['id_pegawai' => $value->id_pegawai, 'tanggal' => $tanggal_awal])
                ->count();
            $sakit = Kehadiran::where(['id_pegawai' => $value->id_pegawai, 'kehadiran' => 'Sakit'])
                ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->count();
            $izin = Kehadiran::where(['id_pegawai' => $value->id_pegawai, 'kehadiran' => 'Izin'])
                ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->count();
            $tanpa_keterangan = Kehadiran::where(['id_pegawai' => $value->id_pegawai, 'kehadiran' => 'Tanpa keterangan'])
                ->whereBetween('created_at', [$tanggal_awal, $tanggal_akhir])
                ->count();

            $data[] = [
                'no' => $key + 1,
                'nip' => $value->NIP,
                'nama' => $value->Nama,
                'hadir' => $hadir,
                'sakit' => $sakit,
                'izin' => $izin,
                'tanpa_keterangan' => $tanpa_keterangan,
            ];
        }

        // Generate PDF dengan data yang sudah diolah
        $pdf = PDF::loadView('laporan', compact('data', 'tanggal_awal', 'tanggal_akhir'));
        
        // Download PDF
        return $pdf->download('laporan_presensi.pdf');
    }
}