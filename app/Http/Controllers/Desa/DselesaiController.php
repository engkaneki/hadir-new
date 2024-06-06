<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Desa\PengajuanAktaLahir;
use App\Models\Desa\PengajuanKematian;
use App\Models\Desa\PengajuanKK;
use App\Models\Desa\PengajuanSuratPindah;
use App\Models\Desa\ProfilModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DselesaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanKK::where('petugas', $user->username)
            ->where('status', 'selesai')
            ->paginate(10);

        $berkas->transform(function ($item) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            return $item;
        });

        return view('desa.pengajuan.kk')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function detailkk($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanKK::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'selesai')
            ->first();

        return view('desa.pengajuan.kk.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function selesailahir()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanAktaLahir::where('petugas', $user->username)
            ->where('status', 'selesai')
            ->paginate(10);

        $berkas->transform(function ($item) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            return $item;
        });

        return view('desa.pengajuan.lahir')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function detaillahir($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanAktaLahir::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'selesai')
            ->first();

        return view('desa.pengajuan.lahir.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function selesaikematian()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanKematian::where('petugas', $user->username)
            ->where('status', 'selesai')
            ->paginate(10);

        $berkas->transform(function ($item) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            return $item;
        });

        return view('desa.pengajuan.kematian')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function detailkematian($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanKematian::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'selesai')
            ->first();

        return view('desa.pengajuan.kematian.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function selesaipindah()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanSuratPindah::where('petugas', $user->username)
            ->where('status', 'selesai')
            ->paginate(10);

        $berkas->transform(function ($item) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            return $item;
        });

        return view('desa.pengajuan.pindah')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function detailpindah($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanSuratPindah::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'selesai')
            ->first();

        return view('desa.pengajuan.pindah.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }
}
