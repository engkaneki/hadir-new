<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Desa\ProfilModel;
use App\Models\Operator\DokterModel;
use App\Models\ProfilRSModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OdokterController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = DokterModel::where('status', 'pending')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('dokter.pengajuan')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function detail($id, $status)
    {
        // Pastikan status yang diberikan adalah valid (pending, selesai, atau ditolak)
        if (!in_array($status, ['pending', 'selesai', 'ditolak'])) {
            abort(404, 'Status tidak valid.');
        }

        $berkas = DokterModel::where('id', $id)
            ->where('status', $status)
            ->first();

        if (!$berkas) {
            abort(404, 'Berkas tidak ditemukan atau status tidak sesuai.');
        }

        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $petugas = User::where('username', $berkas->petugas)->first();
        $kode_user = $petugas->kode_user;
        $profil = ProfilRSModel::where('kode_user', $kode_user)->first();

        return view('dokter.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }


    public function proses(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
            'ket' => 'nullable|string',
        ]);

        try {
            $pengajuan = DokterModel::findOrFail($id);

            $pengajuan->status = $request->input('status');
            $pengajuan->ket = $request->input('ket');
            $pengajuan->save();

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan. Silakan coba lagi.');
        }
    }

    public function selesai()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = DokterModel::where('status', 'selesai')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('dokter.pengajuan')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function ditolak()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $berkas = DokterModel::where('status', 'ditolak')->paginate(10);
        $usernamesPetugas = $berkas->pluck('petugas')->unique();
        $petugas = User::whereIn('username', $usernamesPetugas)->get()->keyBy('username');
        $berkas->transform(function ($item) use ($petugas) {
            $item->tgl_pengajuan = Carbon::parse($item->tgl_pengajuan)->translatedFormat('d F Y');
            $item->nama_petugas = $petugas[$item->petugas]->name ?? null;

            return $item;
        });

        return view('dokter.pengajuan')->with([
            'user' => $user,
            'berkas' => $berkas,
            'petugas' => $petugas,
            'profil_op' => optional($profil_op),
        ]);
    }
}
