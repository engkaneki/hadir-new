<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Desa\PengajuanAktaLahir;
use App\Models\Desa\PengajuanKematian;
use App\Models\Desa\PengajuanKK;
use App\Models\Desa\PengajuanSuratPindah;
use App\Models\Desa\ProfilModel as DesaProfilModel;
use App\Models\ProfilModel;
use App\Models\Operator\BerkasModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpengajuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        if ($user->level == 2) {
            $desa = User::where('kode_operator', $user->kode_user)->get();
            $namaDesa = $desa->pluck('username')->toArray();
            $query = PengajuanKK::where('status', 'pending')
                ->whereIn('petugas', $namaDesa);
        } else {
            $query = PengajuanKK::where('status', 'pending');
        }

        $namaSuami = request('nama');
        if ($namaSuami) {
            $query->where('nama_suami', 'LIKE', '%' . $namaSuami . '%');
        }
        $berkas = $query->paginate(10);

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

    public function selesaikk(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
            'ket' => 'nullable|string',
        ]);

        try {
            $pengajuan = PengajuanKK::findOrFail($id);

            $pengajuan->status = $request->input('status');
            $pengajuan->ket = $request->input('ket');
            $pengajuan->save();

            if ($request->input('status') === 'selesai') {
                $berkas = new BerkasModel();
                $berkas->noreg = $pengajuan->noreg;
                $berkas->nik = $pengajuan->nik_suami;
                $berkas->nama = $pengajuan->nama_suami;
                $berkas->jenis_berkas = 'Kartu Keluarga';
                $berkas->status = $request->input('status');
                $berkas->petugas = $pengajuan->petugas;
                $berkas->save();
            }

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan. Silakan coba lagi.');
        }
    }

    public function detailkk($id)
    {
        $berkas = PengajuanKK::where('id', $id)
            ->where('status', 'pending')
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
        if ($user->level == 2) {
            $desa = User::where('kode_operator', $user->kode_user)->get();
            $namaDesa = $desa->pluck('username')->toArray();
            $query = PengajuanAktaLahir::where('status', 'pending')
                ->whereIn('petugas', $namaDesa);
        } else {
            $query = PengajuanAktaLahir::where('status', 'pending');
        }

        $namaAnak = request('nama');
        if ($namaAnak) {
            $query->where('nama_anak', 'LIKE', '%' . $namaAnak . '%');
        }

        $berkas = $query->paginate(10);

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

    public function selesailahir(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
            'ket' => 'nullable|string',
        ]);

        try {
            $pengajuan = PengajuanAktaLahir::findOrFail($id);

            $pengajuan->status = $request->input('status');
            $pengajuan->ket = $request->input('ket');
            $pengajuan->save();

            if ($request->input('status') === 'selesai') {
                $berkas = new BerkasModel();
                $berkas->noreg = $pengajuan->noreg;
                $berkas->nik = $pengajuan->nik_ayah;
                $berkas->nama = $pengajuan->nama_ayah;
                $berkas->jenis_berkas = 'Akta Kelahiran';
                $berkas->status = $request->input('status');
                $berkas->petugas = $pengajuan->petugas;
                $berkas->save();
            }

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan. Silakan coba lagi.');
        }
    }

    public function detaillahir($id)
    {
        $berkas = PengajuanAktaLahir::where('id', $id)
            ->where('status', 'pending')
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
        if ($user->level == 2) {
            $desa = User::where('kode_operator', $user->kode_user)->get();
            $namaDesa = $desa->pluck('username')->toArray();
            $query = PengajuanKematian::where('status', 'pending')
                ->whereIn('petugas', $namaDesa);
        } else {
            $query = PengajuanKematian::where('status', 'pending');
        }

        $namaMati = request('nama');

        if ($namaMati) {
            $query->where('nama_mati', 'LIKE', '%' . $namaMati . '%');
        }

        $berkas = $query->paginate(10);

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

    public function selesaikematian(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
            'ket' => 'nullable|string',
        ]);

        try {
            $pengajuan = PengajuanKematian::findOrFail($id);

            $pengajuan->status = $request->input('status');
            $pengajuan->ket = $request->input('ket');
            $pengajuan->save();

            if ($request->input('status') === 'selesai') {
                $berkas = new BerkasModel();
                $berkas->noreg = $pengajuan->noreg;
                $berkas->nik = $pengajuan->nik_mati;
                $berkas->nama = $pengajuan->nama_mati;
                $berkas->jenis_berkas = 'Akta Kematian';
                $berkas->status = $request->input('status');
                $berkas->petugas = $pengajuan->petugas;
                $berkas->save();
            }

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan. Silakan coba lagi.');
        }
    }

    public function detailkematian($id)
    {
        $berkas = PengajuanKematian::where('id', $id)
            ->where('status', 'pending')
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
        if ($user->level == 2) {
            $desa = User::where('kode_operator', $user->kode_user)->get();
            $namaDesa = $desa->pluck('username')->toArray();
            $query = PengajuanSuratPindah::where('status', 'pending')
                ->whereIn('petugas', $namaDesa);
        } else {
            $query = PengajuanSuratPindah::where('status', 'pending');
        }

        $namaPelapor = request('nama');

        if ($namaPelapor) {
            $query->where('nama_pelapor', 'LIKE', '%' . $namaPelapor . '%');
        }

        $berkas = $query->paginate(10);

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

    public function selesaipindah(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:selesai,ditolak',
            'ket' => 'nullable|string',
        ]);

        try {
            $pengajuan = PengajuanSuratPindah::findOrFail($id);

            $pengajuan->status = $request->input('status');
            $pengajuan->ket = $request->input('ket');
            $pengajuan->save();

            if ($request->input('status') === 'selesai') {
                $berkas = new BerkasModel();
                $berkas->noreg = $pengajuan->noreg;
                $berkas->nik = $pengajuan->nik_pelapor;
                $berkas->nama = $pengajuan->nama_pelapor;
                $berkas->jenis_berkas = 'Surat Pindah';
                $berkas->status = $request->input('status');
                $berkas->petugas = $pengajuan->petugas;
                $berkas->save();
            }

            return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui status pengajuan. Silakan coba lagi.');
        }
    }

    public function detailpindah($id)
    {
        $berkas = PengajuanSuratPindah::where('id', $id)
            ->where('status', 'pending')
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
