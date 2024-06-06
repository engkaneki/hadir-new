<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Desa\PengajuanAktaLahir;
use App\Models\Desa\PengajuanKematian;
use App\Models\Desa\PengajuanKK;
use App\Models\Desa\PengajuanSuratPindah;
use App\Models\Desa\ProfilModel as DesaProfilModel;
use App\Models\ProfilModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OselesaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = PengajuanKK::where('status', 'selesai')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('desa.pengajuan.kk')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function detailkk($id)
    {
        $berkas = PengajuanKK::where('id', $id)
            ->where('status', 'selesai')
            ->first();
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $petugas = User::where('username', $berkas->petugas)->first();
        $kode_user = $petugas->kode_user;
        $profil = DesaProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.kk.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function lahir()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = PengajuanAktaLahir::where('status', 'selesai')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('desa.pengajuan.lahir')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function detaillahir($id)
    {
        $berkas = PengajuanAktaLahir::where('id', $id)
            ->where('status', 'selesai')
            ->first();
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $petugas = User::where('username', $berkas->petugas)->first();
        $kode_user = $petugas->kode_user;
        $profil = DesaProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.lahir.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function kematian()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = PengajuanKematian::where('status', 'selesai')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('desa.pengajuan.kematian')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function detailkematian($id)
    {
        $berkas = PengajuanKematian::where('id', $id)
            ->where('status', 'selesai')
            ->first();
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $petugas = User::where('username', $berkas->petugas)->first();
        $kode_user = $petugas->kode_user;
        $profil = DesaProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.kematian.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function pindah()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = PengajuanSuratPindah::where('status', 'selesai')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('desa.pengajuan.pindah')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function detailpindah($id)
    {
        $berkas = PengajuanSuratPindah::where('id', $id)
            ->where('status', 'selesai')
            ->first();
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $petugas = User::where('username', $berkas->petugas)->first();
        $kode_user = $petugas->kode_user;
        $profil = DesaProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.pindah.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }
}
