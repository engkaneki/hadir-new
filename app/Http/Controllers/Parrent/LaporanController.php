<?php

namespace App\Http\Controllers\Parrent;

use App\Http\Controllers\Controller;
use App\Models\Desa\PengajuanAktaLahir;
use App\Models\Desa\PengajuanKematian;
use App\Models\Desa\PengajuanKK;
use App\Models\Desa\PengajuanSuratPindah;
use App\Models\ProfilModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $today = Carbon::now();
        $tahun = $today->year;
        $desa = User::where('level', 3)->paginate(10);

        $namaBulan = $today->translatedFormat('F');

        foreach ($desa as $desaUser) {
            $desaUser->pengajuanKKCount = PengajuanKK::where('petugas', $desaUser->username)->count();
            $desaUser->pengajuanAktaLahirCount = PengajuanAktaLahir::where('petugas', $desaUser->username)->count();
            $desaUser->pengajuanKematianCount = PengajuanKematian::where('petugas', $desaUser->username)->count();
            $desaUser->pengajuanSuratPindahCount = PengajuanSuratPindah::where('petugas', $desaUser->username)->count();

            $desaUser->totalPengajuan = $desaUser->pengajuanKKCount + $desaUser->pengajuanAktaLahirCount +
                $desaUser->pengajuanKematianCount + $desaUser->pengajuanSuratPindahCount;
        }

        return view('parrent.laporan.dashboard')->with([
            'user' => $user,
            'profil_op' => optional($profil_op),
            'bulan' => $namaBulan,
            'tahun' => $tahun,
            'desa' => $desa,
        ]);
    }

    public function chartHarian()
    {
        // Ambil tanggal hari ini
        $today = Carbon::now()->toDateString();

        // Mengambil jumlah data harian dengan status pending untuk masing-masing model
        $jumlahKK = PengajuanKK::whereDate('tgl_pengajuan', $today)->count();
        $jumlahAktaKelahiran = PengajuanAktaLahir::whereDate('tgl_pengajuan', $today)->count();
        $jumlahKematian = PengajuanKematian::whereDate('tgl_pengajuan', $today)->count();
        $jumlahSuratPindah = PengajuanSuratPindah::whereDate('tgl_pengajuan', $today)->count();


        // Mengembalikan data dalam format JSON
        return response()->json([
            'jumlahKK' => $jumlahKK ?? 0,
            'jumlahAktaKelahiran' => $jumlahAktaKelahiran ?? 0,
            'jumlahKematian' => $jumlahKematian ?? 0,
            'jumlahSuratPindah' => $jumlahSuratPindah ?? 0,
        ]);
    }

    public function chartBulanan()
    {
        // Ambil informasi tanggal bulan ini
        $today = Carbon::now();
        $startOfMonth = $today->startOfMonth()->toDateString();
        $endOfMonth = $today->endOfMonth()->toDateString();

        // Mengambil jumlah data bulanan dengan status pending untuk masing-masing model
        $jumlahKK = PengajuanKK::whereBetween('tgl_pengajuan', [$startOfMonth, $endOfMonth])->count();
        $jumlahAktaKelahiran = PengajuanAktaLahir::whereBetween('tgl_pengajuan', [$startOfMonth, $endOfMonth])->count();
        $jumlahKematian = PengajuanKematian::whereBetween('tgl_pengajuan', [$startOfMonth, $endOfMonth])->count();
        $jumlahSuratPindah = PengajuanSuratPindah::whereBetween('tgl_pengajuan', [$startOfMonth, $endOfMonth])->count();

        // Mengembalikan data dalam format JSON
        return response()->json([
            'jumlahKK' => $jumlahKK ?? 0,
            'jumlahAktaKelahiran' => $jumlahAktaKelahiran ?? 0,
            'jumlahKematian' => $jumlahKematian ?? 0,
            'jumlahSuratPindah' => $jumlahSuratPindah ?? 0,
        ]);
    }
}
