<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\TbPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateqrcodeController extends Controller
{
    public function generateQRCode()
    {
        $pegawais = TbPegawai::all();
        return view('admin.generateqrcode', compact('pegawais'));
    }
    
    public function downloadQRCode()
    {
        $pegawais = TbPegawai::all();
        $zip = new ZipArchive;
        $zipFileName = 'qrcodes.zip';
        $zipFilePath = public_path($zipFileName);
        $qrcodeDirectory = public_path('qrcode');
        
        // Membuat direktori qrcode jika belum ada
        if (!File::isDirectory($qrcodeDirectory)) {
            File::makeDirectory($qrcodeDirectory);
        }
        
        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE)
        {
            foreach ($pegawais as $pegawai) {
                $qrContent = $pegawai->id_pegawai;
                $qrCode = QrCode::format('png')->size(200)->generate($qrContent);
                $fileName = $pegawai->Nama . '.png';
                $filePath = public_path('qrcode/' . $fileName);
                
                // Menyimpan file QR code
                File::put($filePath, $qrCode);
                $zip->addFile($filePath, $fileName);
            }
            $zip->close();
            
            // Menghapus direktori qrcode setelah file-file QR code ditambahkan ke dalam zip
            File::deleteDirectory($qrcodeDirectory);
            
            // Mengirimkan response untuk download zip dan menghapusnya setelah dikirim
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        }
        
        return redirect()->route('generate.qrcode')->with('error', 'Failed to create zip file');
    }
}
