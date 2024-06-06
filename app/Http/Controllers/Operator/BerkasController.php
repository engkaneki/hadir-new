<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Operator\BerkasModel;
use App\Models\ProfilModel;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerkasController extends Controller
{
    public function operatorbelum(Request $request)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $query = BerkasModel::where('status', 'selesai');

        if ($request->filled('noreg')) {
            $query->where('noreg', 'like', '%' . $request->input('noreg') . '%');
        }

        if ($request->filled('petugas')) {
            $query->where('petugas', $request->input('petugas'));
        }

        $berkas = $query->paginate(10);

        $petugasList = User::where('level', 3)->pluck('name', 'username');

        return view('desa.berkas.belum')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugasList' => $petugasList,
            'profil_op' => optional($profil),
        ]);
    }

    public function cetak(Request $request)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $query = BerkasModel::where('status', 'selesai');

        if ($request->filled('noreg')) {
            $query->where('noreg', 'like', '%' . $request->input('noreg') . '%');
        }

        if ($request->filled('petugas')) {
            $query->where('petugas', $request->input('petugas'));
        }

        $berkas = $query->get();

        $petugasList = User::where('level', 3)->pluck('name', 'username');


        $pdf = \PDF::loadView('desa.berkas.pdf', [
            'user' => $user,
            'berkas' => $berkas,
            'petugasList' => $petugasList,
            'profil_op' => optional($profil),
        ]);

        return $pdf->stream('berkas.pdf');
    }

    public function terima(Request $request, $id)
    {
        $berkas = BerkasModel::find($id);

        if (!$berkas) {
            abort(404);
        }

        $berkas->status = 'terima';
        $berkas->save();

        return redirect()->back()->with('success', 'Berkas berhasil diterima!');
    }

    public function operatorsudah()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = BerkasModel::where('status', 'terima')->paginate(10);
        $petugas = User::where('username', $berkas->first()?->petugas)->first();

        return view('desa.berkas.sudah')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil),
        ]);
    }
}
