<?php

namespace App\Http\Controllers;

use App\Kehadiran;
use App\TbPegawai;
use App\PresensiGuru;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use DateInterval;
use DatePeriod;

class GeneratelaporanController extends Controller
{
    public function show()
    {
        $guru = TbPegawai::where('keterangan', 'guru')->get();
        $honorer = TbPegawai::where('keterangan', 'honorer')->get();
        
        return view('admin.generatelaporan', compact('guru', 'honorer'));
    }
    
    public function generateLaporanGuru(Request $request)
    {
        $bulan = $request->input('tanggalGuru');
        $begin = new DateTime($bulan);
        $end = (new DateTime($begin->format('Y-m-t')))->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        
        $tanggal = [];
        foreach ($period as $date) {
            if (!in_array($date->format('D'), ['Sat', 'Sun'])) {
                $tanggal[] = $date;
            }
        }
        
        $listGuru = TbPegawai::where('keterangan', 'guru')->get();
        $listAbsen = [];
        
        foreach ($listGuru as $guru) {
            foreach ($tanggal as $date) {
                $absen = PresensiGuru::where('id_pegawai', $guru->id_pegawai)
                ->whereDate('tanggal', $date->format('Y-m-d'))
                ->first();
                
                $listAbsen[$guru->id_pegawai][$date->format('d')] = $absen;
            }
        }
        
        $jumlahGuru = [
            'laki' => $listGuru->where('jenis_kelamin', '!=', 'Perempuan')->count(),
            'perempuan' => $listGuru->where('jenis_kelamin', 'Perempuan')->count(),
        ];
        
        $data = [
            'bulan' => $this->convertMonthToIndonesian($begin->format('F')), // Convert month to Indonesian
            'tanggal' => $tanggal,
            'listGuru' => $listGuru,
            'listAbsen' => $listAbsen,
            'jumlahGuru' => $jumlahGuru,
        ];
        
        return view('admin.generateLaporanGuru', $data);
    }
    
    public function generateLaporanHonorer(Request $request)
    {
        $bulan = $request->input('tanggalHonorer');
        $begin = new DateTime($bulan);
        $end = (new DateTime($begin->format('Y-m-t')))->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        
        $tanggal = [];
        foreach ($period as $date) {
            if (!in_array($date->format('D'), ['Sat', 'Sun'])) {
                $tanggal[] = $date;
            }
        }
        
        $listHonorer = TbPegawai::where('keterangan', 'honorer')->get();
        $listAbsen = [];
        
        foreach ($listHonorer as $honorer) {
            foreach ($tanggal as $date) {
                $absen = PresensiGuru::where('id_pegawai', $honorer->id_pegawai)
                ->whereDate('tanggal', $date->format('Y-m-d'))
                ->first();
                
                $listAbsen[$honorer->id_pegawai][$date->format('d')] = $absen;
            }
        }
        
        $jumlahHonorer = [
            'laki' => $listHonorer->where('jenis_kelamin', '!=', 'Perempuan')->count(),
            'perempuan' => $listHonorer->where('jenis_kelamin', 'Perempuan')->count(),
        ];
        
        $data = [
            'bulan' => $this->convertMonthToIndonesian($begin->format('F')), // Convert month to Indonesian
            'tanggal' => $tanggal,
            'listHonorer' => $listHonorer,
            'listAbsen' => $listAbsen,
            'jumlahHonorer' => $jumlahHonorer,
        ];
        
        return view('admin.generateLaporanHonorer', $data);
    }
    
    private function convertMonthToIndonesian($month)
    {
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];
        
        return $months[$month];
    }
}
