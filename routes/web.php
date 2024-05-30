<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GenerateqrcodeController;
use App\Http\Controllers\GeneratelaporanController;
use App\Http\Controllers\AuthController;

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

Route::get('/', [HomeController::class, 'index'])->name("home.index");
Route::post('store', [HomeController::class, 'store'])->name('home.store');

// Rute yang dilindungi oleh autentikasi dan prevent-back-history middleware
Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', function () {
            return view('admin/dashboard');
        });
        Route::get('akun', [AuthController::class, 'lists'])->middleware('admin');

        Route::get('generatelaporan', [GeneratelaporanController::class, 'show'])->name('admin.show');
        Route::post('generateLaporanGuru', [GeneratelaporanController::class, 'generateLaporanGuru'])->name('admin.generateLaporanGuru');
        Route::post('generateLaporanHonorer', [GeneratelaporanController::class, 'generateLaporanHonorer'])->name('admin.generateLaporanHonorer');
        
        Route::get('generate-qrcode', [GenerateqrcodeController::class, 'generateQRCode'])->middleware('admin')->name('generate.qrcode');
        Route::get('download-qrcode', [GenerateqrcodeController::class, 'downloadQRCode'])->middleware('admin')->name('download.qrcode');
        Route::get('generate/zip/{folderName}/{fileName}', [GenerateqrcodeController::class, 'generateZip'])->name('admin.generate.zip');
    });

    Route::get('/absensi', 'AbsensiController@index');
    Route::get('/absensi/{keterangan}', 'AbsensiController@show');
    Route::post('/absensi', 'AbsensiController@create')->name('absensi.create');
    
    Route::get('/pegawai', 'PegawaiController@index');
    Route::get('/pegawai/{id}', 'PegawaiController@show');
    Route::post('/pegawai', 'PegawaiController@create');
    Route::put('/pegawai/update/{id}', 'PegawaiController@update');
    Route::delete('/pegawai/delete/{id_pegawai}', 'PegawaiController@delete');
    Route::post('/pegawai/search', 'PegawaiController@search');
});

// Rute logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk login
Route::get('login', [AuthController::class, 'showForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);