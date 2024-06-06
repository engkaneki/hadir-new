<?php

namespace App\Http\Controllers\Parrent;

use App\Http\Controllers\Controller;
use App\Models\Desa\PengajuanAktaLahir;
use App\Models\Desa\PengajuanKematian;
use App\Models\Desa\PengajuanKK;
use App\Models\Desa\PengajuanSuratPindah;
use App\Models\Operator\BerkasModel;
use App\Models\ProfilModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PdashbordController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();

        $jumlahTotalDesa = 151;
        $jumlahDesa = User::where('level', 3)->count();
        $persentaseDesa = ($jumlahDesa / $jumlahTotalDesa) * 100;

        $totalPengajuan = PengajuanKK::count() +
            PengajuanAktaLahir::count() +
            PengajuanKematian::count() +
            PengajuanSuratPindah::count();

        $totalPengajuanBulanIni = PengajuanKK::whereMonth('tgl_pengajuan', now()->month)
            ->whereYear('tgl_pengajuan', now()->year)
            ->count() +
            PengajuanAktaLahir::whereMonth('tgl_pengajuan', now()->month)
            ->whereYear('tgl_pengajuan', now()->year)
            ->count() +
            PengajuanKematian::whereMonth('tgl_pengajuan', now()->month)
            ->whereYear('tgl_pengajuan', now()->year)
            ->count() +
            PengajuanSuratPindah::whereMonth('tgl_pengajuan', now()->month)
            ->whereYear('tgl_pengajuan', now()->year)
            ->count();

        $totalBerkas = BerkasModel::where('status', 'selesai')->count();

        return view('parrent.dashboard')->with([
            'user' => $user,
            'profil_op' => optional($profil_op),
            'persentaseDesa' => $persentaseDesa,
            'jumlahDesa' => $jumlahDesa,
            'totalPengajuan' => $totalPengajuan,
            'totalPengajuanBulanIni' => $totalPengajuanBulanIni,
            'totalBerkas' => $totalBerkas,
        ]);
    }

    public function users(Request $request)
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();

        $query = User::leftJoin('profil_desa', 'users.kode_user', '=', 'profil_desa.kode_user')
            ->leftJoin('users as operator', 'users.kode_operator', '=', 'operator.kode_user')
            ->where('users.level', '=', 3)
            ->select('users.id', 'users.kode_user', 'users.username', 'users.name', 'profil_desa.alamat', 'profil_desa.email', 'profil_desa.no_hp', 'profil_desa.operator', 'profil_desa.foto_operator', 'operator.name as operator_name');

        if ($request->has('name')) {
            $query->where('users.name', 'like', '%' . $request->input('name') . '%');
        }

        $desa = $query->paginate(10);

        return view('parrent.user.desa')->with([
            'user' => $user,
            'desa' => $desa,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function rs()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();

        $rs = User::leftJoin('profil_rs', 'users.kode_user', '=', 'profil_rs.kode_user')
            ->where('users.level', '=', 4)
            ->select('users.id', 'users.kode_user', 'users.username', 'users.name', 'profil_rs.alamat', 'profil_rs.email', 'profil_rs.no_hp', 'profil_rs.operator', 'profil_rs.foto_operator')
            ->paginate(10);

        return view('parrent.user.rs')->with([
            'user' => $user,
            'rs' => $rs,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function operator()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();

        $operator = User::leftJoin('table_profil', 'users.kode_user', '=', 'table_profil.kode_user')
            ->where('users.level', '=', 2)
            ->select('users.id', 'users.kode_user', 'users.username', 'users.name', 'table_profil.email', 'table_profil.no_hp', 'table_profil.foto')
            ->paginate(10);

        return view('parrent.user.operator')->with([
            'user' => $user,
            'operator' => $operator,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function parrent()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();

        $parrent = User::where('level', 1)->paginate(10);

        return view('parrent.user.parrent')->with([
            'user' => $user,
            'parrent' => $parrent,
            'profil_op' => optional($profil_op),
        ]);
    }

    public function tambahdesa(Request $request)
    {
        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => bcrypt('123'),
            'level' => 3,
            'kode_user' => bcrypt('desa'),
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User Desa berhasil ditambahkan!');
    }

    public function tambahrs(Request $request)
    {
        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => bcrypt('123'),
            'level' => 4,
            'kode_user' => bcrypt('desa'),
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User Desa berhasil ditambahkan!');
    }

    public function tambahparrent(Request $request)
    {
        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => bcrypt('123'),
            'level' => 1,
            'kode_user' => bcrypt('parrent'),
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User Desa berhasil ditambahkan!');
    }

    public function tambahoperator(Request $request)
    {
        $user = new User([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => bcrypt('123'),
            'level' => 2,
            'kode_user' => bcrypt('operator'),
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User Desa berhasil ditambahkan!');
    }

    public function profil()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil_op = ProfilModel::where('kode_user', $kode_user)->first();

        return view('parrent.profil.index')->with([
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

            // dd($profil_op);

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
