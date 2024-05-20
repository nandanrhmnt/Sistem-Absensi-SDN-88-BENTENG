<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\TbPegawai;
use App\PresensiGuru;
use App\Kehadiran;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $pegawai = TbPegawai::paginate(10);
        return view('absensi.listpegawai', compact('pegawai'));
    }
    
    public function show($keterangan)
    {
        
        $pegawai = TbPegawai::where('keterangan', $keterangan)->paginate(10);
        return view('absensi.absensi', compact('pegawai', 'keterangan'));
    }
    
    public function generateQRCodeForAll()
    {
        $pegawai = TbPegawai::all(); // Ambil semua data pegawai
        
        foreach ($pegawai as $p) {
            $qrCode = QrCode::size(200)->generate($p->Nama);
            // Simpan QR code ke dalam file (contoh menggunakan storage)
            $fileName = 'qr_codes/'.$p->Nama.'.png';
            Storage::disk('public')->put($fileName, $qrCode);
            $p->qr_code_path = $fileName; // Simpan path QR code ke dalam model Pegawai
            $p->save();
        }
        
        return redirect()->back()->with('success', 'QR Code berhasil digenerate untuk semua pegawai.');
    }
    
    public function create(Request $request)
    {
        foreach ($request->pegawai as $pegawai_id) {
            $kehadiran = Kehadiran::where('kehadiran', $request->status)->first();
            if ($kehadiran) {
                // Cek jika data presensi sudah ada
                $check = PresensiGuru::where([
                    'id_pegawai' => $pegawai_id,
                    'tanggal' => Carbon::now('Asia/Jakarta')->format('Y-m-d')
                    ])->count();
                    
                    if ($check == 0) {
                        $absen = new PresensiGuru;
                        $absen->id_pegawai = $pegawai_id;
                        $absen->tanggal = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                        $absen->id_kehadiran = $kehadiran->id_kehadiran;
                        $absen->keterangan = $kehadiran->kehadiran;
                        $absen->save();
                    }
                }
            }
            return redirect('/absensi');
        }
    }
    