<?php

use App\Http\Controllers\Desa\BerkasController;
use App\Http\Controllers\Desa\DdashboardController;
use App\Http\Controllers\Desa\DditolakController;
use App\Http\Controllers\Desa\DpengajuanController;
use App\Http\Controllers\Desa\DselesaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Operator\BerkasController as OperatorBerkasController;
use App\Http\Controllers\Operator\ListDesaController;
use App\Http\Controllers\Operator\OdashboardController;
use App\Http\Controllers\Operator\OditolakController;
use App\Http\Controllers\Operator\OdokterController;
use App\Http\Controllers\Operator\OpengajuanController;
use App\Http\Controllers\Operator\OselesaiController;
use App\Http\Controllers\Parrent\DokumenController;
use App\Http\Controllers\Parrent\LaporanController;
use App\Http\Controllers\Parrent\PdashbordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/proses', 'proses');
    Route::get('logout', 'logout');
});

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cekUserLogin:1']], function () {
        Route::controller(PdashbordController::class)->group(function () {
            Route::get('parrent', 'index');
            Route::get('pengguna/desa', 'users');
            Route::get('pengguna/rs', 'rs');
            Route::get('pengguna/parrent', 'parrent');
            Route::get('pengguna/operator', 'operator');
            Route::post('pengguna/tambah', 'tambahdesa');
            Route::post('pengguna/rs/tambah', 'tambahrs');
            Route::post('pengguna/parrent/tambah', 'tambahparrent');
            Route::post('pengguna/operator/tambah', 'tambahoperator');
            Route::get('parrent/profil', 'profil');
            Route::post('parrent/profil/update', 'profilupdate');
            Route::post('parrent/profil/updatefoto', 'updatefoto');
            Route::post('parrent/profil/updatepassword', 'updatepassword');
        });
        Route::controller(OpengajuanController::class)->group(function () {
            Route::get('parrent/pengajuan/kk', 'index');
            Route::put('parrent/pengajuan/kk/selesai/{id}', 'selesaikk');
            Route::get('parrent/pengajuan/kk/detail/{id}', 'detailkk');
            Route::get('parrent/pengajuan/lahir', 'lahir');
            Route::put('parrent/pengajuan/lahir/selesai/{id}', 'selesailahir');
            Route::get('parrent/pengajuan/lahir/detail/{id}', 'detaillahir');
            Route::get('parrent/pengajuan/kematian', 'kematian');
            Route::put('parrent/pengajuan/kematian/selesai/{id}', 'selesaikematian');
            Route::get('parrent/pengajuan/kematian/detail/{id}', 'detailkematian');
            Route::get('parrent/pengajuan/pindah', 'pindah');
            Route::put('parrent/pengajuan/pindah/selesai/{id}', 'selesaipindah');
            Route::get('parrent/pengajuan/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(OselesaiController::class)->group(function () {
            Route::get('parrent/selesai/kk', 'index');
            Route::get('parrent/selesai/kk/detail/{id}', 'detailkk');
            Route::get('parrent/selesai/lahir', 'lahir');
            Route::get('parrent/selesai/lahir/detail/{id}', 'detaillahir');
            Route::get('parrent/selesai/kematian', 'kematian');
            Route::get('parrent/selesai/kematian/detail/{id}', 'detailkematian');
            Route::get('parrent/selesai/pindah', 'pindah');
            Route::get('parrent/selesai/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(OditolakController::class)->group(function () {
            Route::get('parrent/ditolak/kk', 'index');
            Route::get('parrent/ditolak/kk/detail/{id}', 'detailkk');
            Route::get('parrent/ditolak/lahir', 'lahir');
            Route::get('parrent/ditolak/lahir/detail/{id}', 'detaillahir');
            Route::get('parrent/ditolak/kematian', 'kematian');
            Route::get('parrent/ditolak/kematian/detail/{id}', 'detailkematian');
            Route::get('parrent/ditolak/pindah', 'pindah');
            Route::get('parrent/ditolak/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(OperatorBerkasController::class)->group(function () {
            Route::get('parrent/berkas/belum', 'operatorbelum');
            Route::put('parrent/berkas/terima/{id}', 'terima');
            Route::get('parrent/berkas/sudah', 'operatorsudah');
            Route::get('parrent/berkas/cetak', 'cetak');
        });
        Route::controller(LaporanController::class)->group(function () {
            Route::get('parrent/laporan', 'index')->name('laporan');
            Route::get('parrent/chart-harian', 'chartHarian');
            Route::get('parrent/chart-bulanan', 'chartBulanan');
        });
        Route::controller(ListDesaController::class)->group(function () {
            Route::get('pengguna/operator/desa/{username}', 'index');
            Route::put('listdesa/tambah/{username}', 'tambah');
        });
        Route::controller(DokumenController::class)->group(function () {
            Route::get('parrent/dokumen', 'index')->name('dokumen');
            Route::post('dokumen/tambah', 'tambah');
            Route::put('dokumen/edit/{id}', 'edit');
            Route::delete('dokumen/hapus/{id}', 'hapus');
        });
    });

    Route::group(['middleware' => ['cekUserLogin:2']], function () {
        Route::controller(OdashboardController::class)->group(function () {
            Route::get('operator', 'index');
            Route::get('operator/profil', 'profil');
            Route::post('operator/profil/update', 'profilupdate');
            Route::post('operator/profil/updatefoto', 'updatefoto');
            Route::post('operator/profil/updatepassword', 'updatepassword');
        });
        Route::controller(OpengajuanController::class)->group(function () {
            Route::get('operator/pengajuan/kk', 'index');
            Route::put('operator/pengajuan/kk/selesai/{id}', 'selesaikk');
            Route::get('operator/pengajuan/kk/detail/{id}', 'detailkk');
            Route::get('operator/pengajuan/lahir', 'lahir');
            Route::put('operator/pengajuan/lahir/selesai/{id}', 'selesailahir');
            Route::get('operator/pengajuan/lahir/detail/{id}', 'detaillahir');
            Route::get('operator/pengajuan/kematian', 'kematian');
            Route::put('operator/pengajuan/kematian/selesai/{id}', 'selesaikematian');
            Route::get('operator/pengajuan/kematian/detail/{id}', 'detailkematian');
            Route::get('operator/pengajuan/pindah', 'pindah');
            Route::put('operator/pengajuan/pindah/selesai/{id}', 'selesaipindah');
            Route::get('operator/pengajuan/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(OselesaiController::class)->group(function () {
            Route::get('operator/selesai/kk', 'index');
            Route::get('operator/selesai/kk/detail/{id}', 'detailkk');
            Route::get('operator/selesai/lahir', 'lahir');
            Route::get('operator/selesai/lahir/detail/{id}', 'detaillahir');
            Route::get('operator/selesai/kematian', 'kematian');
            Route::get('operator/selesai/kematian/detail/{id}', 'detailkematian');
            Route::get('operator/selesai/pindah', 'pindah');
            Route::get('operator/selesai/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(OditolakController::class)->group(function () {
            Route::get('operator/ditolak/kk', 'index');
            Route::get('operator/ditolak/kk/detail/{id}', 'detailkk');
            Route::get('operator/ditolak/lahir', 'lahir');
            Route::get('operator/ditolak/lahir/detail/{id}', 'detaillahir');
            Route::get('operator/ditolak/kematian', 'kematian');
            Route::get('operator/ditolak/kematian/detail/{id}', 'detailkematian');
            Route::get('operator/ditolak/pindah', 'pindah');
            Route::get('operator/ditolak/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(OperatorBerkasController::class)->group(function () {
            Route::get('operator/berkas/belum', 'operatorbelum');
            Route::put('operator/berkas/terima/{id}', 'terima');
            Route::get('operator/berkas/sudah', 'operatorsudah');
        });
        Route::controller(OdokterController::class)->group(function () {
            Route::get('operator/dokter/pengajuan', 'index');
            Route::get('operator/dokter/detail/{id}/{status}', 'detail');
            Route::put('operator/dokter/proses/{id}', 'proses');
            Route::get('operator/dokter/selesai', 'selesai');
            Route::get('operator/dokter/ditolak', 'ditolak');
        });
    });

    Route::group(['middleware' => ['cekUserLogin:3']], function () {
        // Route::get('/', function () {
        //     return view('welcome');
        // });


        Route::controller(DdashboardController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/chart-data', 'chartData');
            Route::get('profil', 'profil');
            Route::post('profil/update', 'profilupdate');
            Route::post('profil/updatefoto', 'updatefoto');
            Route::post('profil/updatepassword', 'updatepassword');
        });
        Route::controller(DpengajuanController::class)->group(function () {
            Route::get('pengajuan/kk', 'index')->name('pengajuan-kk');
            Route::get('pengajuan/kk/tambah', 'tambahkk');
            Route::post('pengajuan/kk/simpan', 'simpankk');
            Route::get('pengajuan/kk/detail/{id}', 'detailkk');
            Route::delete('pengajuan/kk/hapus/{id}', 'hapuskk');
            Route::get('pengajuan/lahir', 'lahir')->name('pengajuan-lahir');
            Route::get('pengajuan/lahir/tambah', 'tambahlahir');
            Route::post('pengajuan/lahir/simpan', 'simpanlahir');
            Route::get('pengajuan/lahir/detail/{id}', 'detaillahir');
            Route::delete('pengajuan/lahir/hapus/{id}', 'hapuslahir');
            Route::get('pengajuan/kematian', 'kematian')->name('pengajuan-kematian');
            Route::get('pengajuan/kematian/tambah', 'tambahkematian');
            Route::post('pengajuan/kematian/simpan', 'simpankematian');
            Route::get('pengajuan/kematian/detail/{id}', 'detailkematian');
            Route::delete('pengajuan/kematian/hapus/{id}', 'hapuskematian');
            Route::get('pengajuan/pindah', 'pindah')->name('pengajuan-pindah');
            Route::get('pengajuan/pindah/tambah', 'tambahpindah');
            Route::post('pengajuan/pindah/simpan', 'simpanpindah');
            Route::get('pengajuan/pindah/detail/{id}', 'detailpindah');
            Route::delete('pengajuan/pindah/hapus/{id}', 'hapuspindah');
        });
        Route::controller(DselesaiController::class)->group(function () {
            Route::get('selesai/kk', 'index');
            Route::get('selesai/kk/detail/{id}', 'detailkk');
            Route::get('selesai/lahir', 'selesailahir');
            Route::get('selesai/lahir/detail/{id}', 'detaillahir');
            Route::get('selesai/kematian', 'selesaikematian');
            Route::get('selesai/kematian/detail/{id}', 'detailkematian');
            Route::get('selesai/pindah', 'selesaipindah');
            Route::get('selesai/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(DditolakController::class)->group(function () {
            Route::get('ditolak/kk', 'index');
            Route::get('ditolak/kk/detail/{id}', 'detailkk');
            Route::get('ditolak/lahir', 'ditolaklahir');
            Route::get('ditolak/lahir/detail/{id}', 'detaillahir');
            Route::get('ditolak/kematian', 'ditolakkematian');
            Route::get('ditolak/kematian/detail/{id}', 'detailkematian');
            Route::get('ditolak/pindah', 'ditolakpindah');
            Route::get('ditolak/pindah/detail/{id}', 'detailpindah');
        });
        Route::controller(BerkasController::class)->group(function () {
            Route::get('berkas/belum', 'belum');
            Route::get('berkas/sudah', 'sudah');
        });
        Route::controller(DokumenController::class)->group(function () {
            Route::get('dokumen', 'desa');
        });
    });
});
