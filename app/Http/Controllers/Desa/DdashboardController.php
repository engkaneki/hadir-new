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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DdashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil = ProfilModel::where('kode_user', $user->kode_user)->first();
        $kk = PengajuanKK::where('status', 'pending')
            ->where('petugas', $user->username)
            ->count();
        $lahir = PengajuanAktaLahir::where('status', 'pending')
            ->where('petugas', $user->username)
            ->count();
        $kematian = PengajuanKematian::where('status', 'pending')
            ->where('petugas', $user->username)
            ->count();
        $pindah = PengajuanSuratPindah::where('status', 'pending')
            ->where('petugas', $user->username)
            ->count();

        $chartData = $this->chartData($user->username);

        return view('desa.dashboard')->with([
            'user' => $user,
            'profil' => optional($profil),
            'chartData' => $chartData,
            'kk' => $kk,
            'lahir' => $lahir,
            'kematian' => $kematian,
            'pindah' => $pindah,
        ]);
    }

    public function chartData($username)
    {
        $pengajuanKK = PengajuanKK::where('petugas', $username)->get();
        $pengajuanAktaLahir = PengajuanAktaLahir::where('petugas', $username)->get();
        $pengajuanKematian = PengajuanKematian::where('petugas', $username)->get();
        $pengajuanSuratPindah = PengajuanSuratPindah::where('petugas', $username)->get();

        $models = [
            'Surat Pindah' => $pengajuanSuratPindah,
            'Akta Kematian' => $pengajuanKematian,
            'Kartu Keluarga' => $pengajuanKK,
            'Akta Lahir' => $pengajuanAktaLahir,
        ];

        $allMonths = collect([]);
        $startDate = \Carbon\Carbon::now()->subMonths(11)->startOfMonth();
        $endDate = \Carbon\Carbon::now()->endOfMonth();
        $currentDate = $startDate;


        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $allMonths->push($currentDate->format('F Y'));
            $currentDate->addMonth();
        }

        $allMonths = $allMonths->values();

        $monthlyData = [];
        foreach ($models as $modelName => $modelData) {
            $monthlyData[$modelName] = $allMonths->map(function ($month) use ($modelData) {
                return $modelData->filter(function ($item) use ($month) {
                    return \Carbon\Carbon::parse($item->tgl_pengajuan)->format('F Y') === $month;
                })->count();
            });
        }

        $dataValues = [];
        foreach ($models as $modelName => $model) {
            $dataValues[] = [
                'name' => $modelName,
                'data' => $monthlyData[$modelName]->map(function ($count) {
                    return (int)$count;
                })->toArray(),
            ];
        }

        $labels = $allMonths->toArray();

        return [
            'labels' => $labels,
            'data' => $dataValues,
        ];
    }

    public function profil()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.profil.index')->with([
            'user' => $user,
            'profil' => optional($profil),
        ]);
    }

    public function profilupdate(Request $r)
    {
        try {
            $user = Auth::user();

            $kode_user = $user->kode_user;
            $nama_desa = $r->input('name');

            $desa = ProfilModel::where('kode_user', $kode_user)->first();

            if (!$desa) {
                $desa = new ProfilModel();
                $desa->kode_user = $kode_user;
            }

            $desa->alamat = $r->input('alamat', $desa->alamat);
            $desa->email = $r->input('email', $desa->email);
            $desa->no_hp = $r->input('no_hp', $desa->no_hp);
            $desa->operator = $r->input('operator', $desa->operator);

            $desa->save();

            $user->name = $nama_desa;
            $user->save();

            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }
    }

    public function updateFoto(Request $r)
    {
        try {
            $user = Auth::user();
            $kode_user = $user->kode_user;

            $desa = ProfilModel::where('kode_user', $kode_user)->first();

            if (!$desa) {
                $desa = new ProfilModel();
                $desa->kode_user = $kode_user;
            }

            $r->validate([
                'foto_operator' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($desa->foto_operator) {
                Storage::delete('public/avatars/' . $desa->foto_operator);
            }

            if ($r->hasFile('foto_operator')) {
                $file = $r->file('foto_operator');
                $timestamp = now()->timestamp;

                $fileName = $user->name . '_operator_desa_' . $timestamp . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('avatars', $fileName, 'public');
                $desa->foto_operator = basename($path);
            }

            $desa->save();

            return redirect()->back()->with('success', 'Foto operator berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan foto operator. Silakan coba lagi.');
        }
    }

    public function updatepassword(Request $r)
    {
        // Validasi data dari formulir
        $r->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ], [
            'old_password.required' => 'Isi password saat ini',
            'new_password.required' => 'Isi password baru',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai'
        ]);

        $user = Auth::user();

        if (!Hash::check($r->input('old_password'), $user->password)) {
            return redirect()->back()->with('error', 'Password saat ini tidak sesuai.');
        }

        $user->password = bcrypt($r->input('new_password'));
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
