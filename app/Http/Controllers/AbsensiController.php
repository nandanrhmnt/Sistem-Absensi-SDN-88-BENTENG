<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TbPegawai;
use App\PresensiGuru;
use App\Kehadiran;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $pegawai = TbPegawai::paginate(10);
        return view('admin.absensi.listpegawai', compact('pegawai'));
    }

    public function show($keterangan)
    {
        // Mengambil tanggal saat ini
        $tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        // Mengambil data pegawai berdasarkan keterangan kehadiran
        $pegawai = TbPegawai::where('keterangan', $keterangan)->paginate(10);

        // Mengambil data presensi untuk hari ini
        $presensiHariIni = PresensiGuru::whereDate('tanggal', $tanggal)->get()->pluck('id_pegawai');

        return view('admin.absensi.absensi', compact('pegawai', 'keterangan', 'presensiHariIni'));
    }
    
    public function create(Request $request)
    {
        foreach ($request->pegawai as $id_pegawai) {
            // Memeriksa apakah keterangan kehadiran tersedia dalam request
            if (isset($request->keterangan[$id_pegawai])) {
                // Mengambil keterangan kehadiran dari request
                $keterangan = $request->keterangan[$id_pegawai];

                // Menyimpan data kehadiran
                $kehadiran = Kehadiran::create([
                    'id_pegawai' => $id_pegawai,
                    'kehadiran' => $keterangan,
                ]);

                // Menyimpan data presensi
                PresensiGuru::create([
                    'id_pegawai' => $id_pegawai,
                    'tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d'),
                    'id_kehadiran' => $kehadiran->id_kehadiran,
                    'jam_masuk' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
                ]);
            }
        }

        return redirect('/absensi')->with('notif', [
            'success' => true,
            'msgaction' => 'Data presensi berhasil disimpan.'
        ]);
    }
}
