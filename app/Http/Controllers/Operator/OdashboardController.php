<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Desa\PengajuanAktaLahir;
use App\Models\Desa\PengajuanKematian;
use App\Models\Desa\PengajuanKK;
use App\Models\Desa\PengajuanSuratPindah;
use App\Models\Operator\BerkasModel;
use App\Models\Operator\DokterModel;
use App\Models\ProfilModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OdashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();
        $kk = PengajuanKK::where('status', 'pending')->count();
        $lahir = PengajuanAktaLahir::where('status', 'pending')->count();
        $kematian = PengajuanKematian::where('status', 'pending')->count();
        $pindah = PengajuanSuratPindah::where('status', 'pending')->count();
        $dokter = DokterModel::where('status', 'pending')->count();
        $kks = PengajuanKK::where('status', 'selesai')->count();
        $lahirs = PengajuanAktaLahir::where('status', 'selesai')->count();
        $kematians = PengajuanKematian::where('status', 'selesai')->count();
        $pindahs = PengajuanSuratPindah::where('status', 'selesai')->count();
        $selesai = $kks + $lahirs + $kematians + $pindahs;
        $belumantar = BerkasModel::where('status', 'selesai')->count();
        $kkt = PengajuanKK::count();
        $lahirt = PengajuanAktaLahir::count();
        $kematiant = PengajuanKematian::count();
        $pindaht = PengajuanSuratPindah::count();
        $doktert = DokterModel::count();
        $totalBerkas = $kkt + $lahirt + $kematiant + $pindaht + $doktert;

        $chartData = $this->chartData($user->username);

        return view('operator.dashboard')->with([
            'user' => $user,
            'chartData' => $chartData,
            'profil_op' => optional($profil_op),
            'kk' => $kk,
            'lahir' => $lahir,
            'kematian' => $kematian,
            'pindah' => $pindah,
            'dokter' => $dokter,
            'selesai' => $selesai,
            'belumantar' => $belumantar,
            'totalBerkas' => $totalBerkas,
        ]);
    }

    public function chartData($username)
    {
        $pengajuanKK = PengajuanKK::get();
        $pengajuanAktaLahir = PengajuanAktaLahir::get();
        $pengajuanKematian = PengajuanKematian::get();
        $pengajuanSuratPindah = PengajuanSuratPindah::get();

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
        $profil_op = ProfilModel::where('kode_user', $kode_user)->first();

        return view('operator.profil.index')->with([
            'user' => $user,
            'profil_op' => optional($profil_op),
        ]);
    }


    public function profilupdate(Request $r)
    {
        try {
            $user = Auth::user();

            $kode_user = $user->kode_user;
            $nama = $r->input('name');

            $profil_op = ProfilModel::where('kode_user', $kode_user)->first();

            if (!$profil_op) {
                $profil_op = new ProfilModel();
                $profil_op->kode_user = $kode_user;
            }

            $profil_op->email = $r->input('email', $profil_op->email);
            $profil_op->no_hp = $r->input('no_hp', $profil_op->no_hp);

            $profil_op->save();

            $user->name = $nama;
            $user->save();

            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data profil. Silakan coba lagi.');
        }
    }

    public function updateFoto(Request $r)
    {
        try {
            $user = Auth::user();
            $kode_user = $user->kode_user;

            $profil_op = ProfilModel::where('kode_user', $kode_user)->first();

            if (!$profil_op) {
                $profil_op = new ProfilModel();
                $profil_op->kode_user = $kode_user;
            }

            $r->validate([
                'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($profil_op->foto) {
                Storage::delete('public/avatars/' . $profil_op->foto);
            }

            if ($r->hasFile('foto')) {
                $file = $r->file('foto');
                $timestamp = now()->timestamp;

                $fileName = $user->name . ' ' . $timestamp . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('avatars', $fileName, 'public');
                $profil_op->foto = basename($path);
            }

            $profil_op->save();

            return redirect()->back()->with('success', 'Foto operator berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan foto operator. Silakan coba lagi.');
        }
    }

    public function updatepassword(Request $r)
    {
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
