<?php

namespace App\Http\Controllers;

use index;
use App\Kehadiran;
use App\TbPegawai;
use Carbon\Carbon;
use App\PresensiGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->akses == "Siswa" || Auth::user()->akses == "Ortu") {
                return redirect('u/dashboard');
            } else if (Auth::user()->akses == "Admin" || Auth::user()->akses == "Piket") {
                $pegawai_count = TbPegawai::count();
                $presensi_count = PresensiGuru::whereDate('created_at', Carbon::today())->count();
                return view('admin/dashboard', compact('pegawai_count', 'presensi_count'));
            }
        } else {
            return view('layouts/home');
        }
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = \Validator::make($request->all(), [
            'id_pegawai' => 'required|integer|exists:tb_pegawai,id_pegawai',
            'jam_masuk' => 'required|date_format:H:i'
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput()
                ->with('gagal', 'Validasi gagal. Silakan periksa input Anda.');
        }

        $tanggal = Carbon::now()->format('Y-m-d');

        // Cek apakah sudah ada presensi hari ini
        $cek = PresensiGuru::where([
            'id_pegawai' => $request->id_pegawai,
            'tanggal' => $tanggal
        ])->first();

        if ($cek) {
            return redirect('/')->with('gagal', 'Hari ini Anda telah absen');
        }

        // Tambah ke tabel kehadiran
        $kehadiran = Kehadiran::firstOrCreate([
            'id_pegawai' => $request->id_pegawai,
            'kehadiran' => 'Hadir'
        ]);

        // Simpan data presensi
        PresensiGuru::create([
            'id_pegawai' => $request->id_pegawai,
            'id_kehadiran' => $kehadiran->id_kehadiran,
            'tanggal' => $tanggal,
            'jam_masuk' => $request->jam_masuk
        ]);

        return redirect('/')->with('success', 'Terimakasih, Data Tersimpan');
        // dd($request->all());
    }
}
