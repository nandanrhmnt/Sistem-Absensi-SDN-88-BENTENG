<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\GenerateqrcodeController;
use App\Http\Controllers\GeneratelaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index')->name("home.index");
Route::post('store', [HomeController::class, 'store'])->name('home.store');
// Route::post('validasi', [HomeController::class, 'validasi'])->name('validasi');

Route::prefix('admin')->group(function () {
    Route::get('dashboard', function () {
        return view('admin/dashboard');
    });
    // Route::get('kelas/', 'KelasController@index')->middleware('admin');
    // Route::get('kelas/{id}', 'KelasController@show')->middleware('admin');
    // Route::get('siswa/', 'SiswaController@index')->middleware('admin');
    // Route::get('siswa/pdf', 'SiswaController@pdf')->middleware('admin');
    Route::get('akun','AuthController@lists')->middleware('admin');
    Route::get('all','PegawaiController@all')->middleware('admin');
    Route::get('guru','PegawaiController@guru')->middleware('admin');
    Route::get('honorer','PegawaiController@honorer')->middleware('admin');
    Route::post('generatelaporan', [GeneratelaporanController::class, 'generatePDF'])->name('admin.generatelaporan');
    Route::get('generate-qrcode', [GenerateqrcodeController::class, 'generateQRCode'])->middleware('admin')->name('generate.qrcode');
    Route::get('download-qrcode', [GenerateqrcodeController::class, 'downloadQRCode'])->middleware('admin')->name('download.qrcode');
    Route::get('generate/zip/{folderName}/{fileName}', [GenerateqrcodeController::class, 'generateZip'])->name('admin.generate.zip');
});

// Route::get('/absensi/', 'AbsensiController@index');
// Route::get('/absensi/{id_pegawai}', 'AbsensiController@show');
// Route::post('/absensi/','AbsensiController@create');
Route::get('/absensi', 'AbsensiController@index'); // Menampilkan semua pegawai
Route::get('/absensi/{keterangan}', 'AbsensiController@show');
Route::get('/absensi/generate-qr-all', 'AbsensiController@generateQRCodeForAll')->name('absensi.generate_qr_all');
// Route::get('/absensi/guru', 'AbsensiController@indexGuru'); // Menampilkan pegawai dengan keterangan 'guru'
// Route::get('/absensi/honorer', 'AbsensiController@indexHonorer'); // Menampilkan pegawai dengan keterangan 'honorer'


// Route::post('/kelas/', 'KelasController@create');
// Route::put('/kelas/', 'KelasController@update');
// Route::delete('/kelas/delete/{id}', 'KelasController@delete');

// Route::get('/siswa/{id}', 'SiswaController@show');
// Route::post('/siswa/', 'SiswaController@create');
// Route::put('/siswa/', 'SiswaController@update');
// Route::delete('/siswa/delete/{id}', 'SiswaController@delete');
// Route::post('/siswa/search/', 'SiswaController@search');

Route::get('/pegawai/', 'PegawaiController@index');
Route::get('/pegawai/{id}', 'PegawaiController@show');
Route::post('/pegawai/','PegawaiController@create');
Route::put('/pegawai/update/{id}', 'PegawaiController@update');
Route::get('/pegawai/delete/{id}', 'PegawaiController@delete');
Route::post('/pegawai/search/', 'PegawaiController@search');

Route::get('/admin/rekap/','RekapController@index');
Route::get('/admin/rekap/{table}','RekapController@show');
Route::post('/rekap/pribadipdf/','RekapController@pdf');
Route::get('/rekap/kelas/{id}','RekapController@rekap');
Route::post('/rekap/','RekapController@hitung');

// Route::post('/siswakelas/', 'SiswaKelasController@create')->middleware('admin');
// Route::get('/siswakelas/{id}', 'SiswaKelasController@add')->middleware('admin');
// Route::delete('/siswakelas/delete/{id}', 'SiswaKelasController@delete')->middleware('admin');


Route::get('register','AuthController@daftar');
Route::post('register','AuthController@prosesDaftar');

Route::post('/akun/','AuthController@create');
Route::put('/akun/', 'AuthController@update');
Route::delete('akun/delete/{id}','AuthController@delete');

// Route::prefix('u')->group(function(){
//     Route::get('dashboard','UserController@index')->middleware('logged');
// });

Route::get('logout','AuthController@logout');
Route::get('admin', 'AuthController@showForm');
Route::get('piket', 'AuthController@showForm');
Route::get('login', 'AuthController@showForm');
Route::post('login', 'AuthController@login');

Route::get('panduan',function(){
    return view('panduan/panduan');
});

// Route::get('/qr', function()
// {
    // 	return QrCode::size(250)
    // 	->backgroundColor(255, 255, 204)
    // 	->generate('BELAJAR QR');
    // });