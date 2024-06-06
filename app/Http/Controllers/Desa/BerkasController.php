<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use App\Models\Desa\ProfilModel;
use App\Models\Operator\BerkasModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerkasController extends Controller
{
    public function belum()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = BerkasModel::where('petugas', $user->username)
            ->where('status', 'selesai')
            ->paginate(10);

        return view('desa.berkas.belum')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function sudah()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = BerkasModel::where('petugas', $user->username)
            ->where('status', 'terima')
            ->paginate(10);

        return view('desa.berkas.sudah')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }
}
