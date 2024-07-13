<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\ProfilModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListDesaController extends Controller
{
    public function index($username)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $operator = User::where('username', $username)->first();
        $listdesa = User::where('kode_operator', $operator->kode_user)->paginate(10);
        $alldesa = User::where('level', 3)->get();

        return view('parrent.desa.list')->with([
            'user' => $user,
            'profil_op' => optional($profil),
            'operator' => $operator,
            'listdesa' => $listdesa,
            'alldesa' => $alldesa,
        ]);
    }

    public function tambah(Request $request, $username)
    {
        try {
            $nama_desa = $request->nama_desa;
            $user = User::where('username', $username)->first();
            $desa = User::where('username', $nama_desa)->first();

            if (!$desa) {
                throw new \Exception('Desa tidak ditemukan');
            }

            // Pemeriksaan apakah desa sudah memiliki kode_operator
            // if ($desa->kode_operator !== null) {
            //     throw new \Exception('Desa sudah memiliki operator');
            // }

            $desa->kode_operator = $user->kode_user;
            $desa->save();

            return redirect()->back()->with('success', 'Desa berhasil ditambah ke list');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}