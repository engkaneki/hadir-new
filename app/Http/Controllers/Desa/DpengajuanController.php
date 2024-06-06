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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DpengajuanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanKK::where('petugas', $user->username)
            ->where('status', 'pending')
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

    public function tambahkk()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.kk.tambah')->with([
            'user' => $user,
            'profil' => optional($profil),
        ]);
    }

    public function simpankk(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'no_hp' => 'required|numeric',
            'nik_suami' => 'required|string',
            'nama_suami' => 'required|string',
            'nik_istri' => 'required|numeric',
            'nama_istri' => 'required|string',
            'det' => 'nullable|string',
            'kk_suami' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'kk_istri' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'ktp_suami' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'ktp_istri' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'buku_nikah' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'buku_nikah_ortu' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'buku_nikah_ortu2' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'surat_pindah' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'lainnya' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'in' => 'Kolom :attribute tidak valid.',
            'date' => 'Format :attribute tidak valid.',
            'image' => 'File :attribute harus berupa gambar.',
            'mimes' => 'Format file :attribute tidak valid. Gunakan format jpeg, png, jpg, atau gif, pdf.',
            'max' => 'Ukuran file :attribute tidak boleh melebihi 2048 KB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuanKK = new PengajuanKK();

            $latestNoreg = PengajuanKK::whereDate('tgl_pengajuan', now()->toDateString())->latest('noreg')->first();
            $nomorUrut = $latestNoreg ? (int)substr($latestNoreg->noreg, -3) : 0;
            $nomorUrut = ($nomorUrut % 999) + 1;
            $noreg = '1219/didesa/kk/' . now()->format('dmY') . '/' . sprintf('%03d', $nomorUrut);
            $pengajuanKK->noreg = $noreg;

            $pengajuanKK->noreg = $noreg;

            $pengajuanKK->tgl_pengajuan = now();
            $pengajuanKK->status = 'pending';
            $pengajuanKK->petugas = Auth::user()->username;

            $pengajuanKK->kk_suami = $r->file('kk_suami') ? $this->uploadKK($r->file('kk_suami'), 'nik_kk_suami') : null;
            $pengajuanKK->kk_istri = $r->file('kk_istri') ? $this->uploadKK($r->file('kk_istri'), 'nik_kk_istri') : null;
            $pengajuanKK->ktp_suami = $r->file('ktp_suami') ? $this->uploadKK($r->file('ktp_suami'), 'nik_ktp_suami') : null;
            $pengajuanKK->ktp_istri = $r->file('ktp_istri') ? $this->uploadKK($r->file('ktp_istri'), 'nik_ktp_istri') : null;
            $pengajuanKK->buku_nikah = $r->file('buku_nikah') ? $this->uploadKK($r->file('buku_nikah'), 'nik_buku_nikah') : null;
            $pengajuanKK->buku_nikah_ortu = $r->file('buku_nikah_ortu') ? $this->uploadKK($r->file('buku_nikah_ortu'), 'nik_buku_nikah_ortu') : null;
            $pengajuanKK->buku_nikah_ortu2 = $r->file('buku_nikah_ortu2') ? $this->uploadKK($r->file('buku_nikah_ortu2'), 'nik_buku_nikah_ortu2') : null;
            $pengajuanKK->surat_pindah = $r->file('surat_pindah') ? $this->uploadKK($r->file('surat_pindah'), 'nik_surat_pindah') : null;
            $pengajuanKK->lainnya = $r->file('lainnya') ? $this->uploadKK($r->file('lainnya'), 'nik_lainnya') : null;

            $pengajuanKK->no_hp = $r->input('no_hp');
            $pengajuanKK->nik_suami = $r->input('nik_suami');
            $pengajuanKK->nama_suami = $r->input('nama_suami');
            $pengajuanKK->nik_istri = $r->input('nik_istri');
            $pengajuanKK->nama_istri = $r->input('nama_istri');
            $pengajuanKK->detail = $r->input('det');

            $pengajuanKK->save();

            return redirect()->route('pengajuan-kk')->with('success', 'Pengajuan KK berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pengajuan KK. Silakan coba lagi.');
        }
    }

    private function uploadKK($file, $prefix)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = "{$prefix}_{$file->hashName()}";
        $path = $file->storeAs('uploads/kk', $fileName, 'public');

        return basename($path);
    }

    public function detailkk($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanKK::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'pending')
            ->first();

        return view('desa.pengajuan.kk.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function hapuskk($id)
    {
        try {
            $pengajuanKK = PengajuanKK::findOrFail($id);

            $this->hapusFileKK($pengajuanKK->kk_suami);
            $this->hapusFileKK($pengajuanKK->kk_istri);
            $this->hapusFileKK($pengajuanKK->ktp_suami);
            $this->hapusFileKK($pengajuanKK->ktp_istri);
            $this->hapusFileKK($pengajuanKK->buku_nikah);
            $this->hapusFileKK($pengajuanKK->buku_nikah_ortu);
            $this->hapusFileKK($pengajuanKK->buku_nikah_ortu2);
            $this->hapusFileKK($pengajuanKK->surat_pindah);
            $this->hapusFileKK($pengajuanKK->lainnya);

            $pengajuanKK->delete();

            return redirect()->route('pengajuan-kk')->with('success', 'Data pengajuan KK berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengajuan KK. Silakan coba lagi.');
        }
    }

    private function hapusFileKK($file)
    {
        if ($file && Storage::exists('public/uploads/kk/' . $file)) {
            Storage::delete('public/uploads/kk/' . $file);
        }
    }

    public function lahir()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanAktaLahir::where('petugas', $user->username)
            ->where('status', 'pending')
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

    public function tambahlahir()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.lahir.tambah')->with([
            'user' => $user,
            'profil' => optional($profil),
        ]);
    }

    public function simpanlahir(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'no_hp' => 'required|numeric',
            'no_kk' => 'required|numeric',
            'nama_anak' => 'required|string',
            'jk_anak' => 'required|string|in:Laki-Laki,Perempuan',
            'tgl_lahir' => 'required|date',
            'jenis_kelahiran' => 'required|string|in:Tunggal,Kembar 2,Kembar 3,Kembar 4,Kembar 5,Lainnya',
            'anak_ke' => 'required|numeric',
            'berat' => 'required|numeric',
            'panjang' => 'required|numeric',
            'nik_ibu' => 'required|numeric',
            'nama_ibu' => 'required|string',
            'nik_ayah' => 'required|numeric',
            'nama_ayah' => 'required|string',
            'detail' => 'nullable|string',
            'surat_pengantar' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'surat_lahir' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'kk' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'ktp_ayah' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'ktp_ibu' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'buku_nikah' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'lainnya' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'required' => 'Kolom :attribute wajib diisi.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'in' => 'Kolom :attribute tidak valid.',
            'date' => 'Format :attribute tidak valid.',
            'image' => 'File :attribute harus berupa gambar.',
            'mimes' => 'Format file :attribute tidak valid. Gunakan format jpeg, png, jpg, atau gif, pdf.',
            'max' => 'Ukuran file :attribute tidak boleh melebihi 2048 KB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuanLahir = new PengajuanAktaLahir();

            $latestNoreg = PengajuanAktaLahir::whereDate('tgl_pengajuan', now()->toDateString())->latest('noreg')->first();
            $nomorUrut = $latestNoreg ? (int)substr($latestNoreg->noreg, -3) : 0;
            $nomorUrut = ($nomorUrut % 999) + 1;
            $noreg = '1219/didesa/lahir/' . now()->format('dmY') . '/' . sprintf('%03d', $nomorUrut);
            $pengajuanLahir->noreg = $noreg;

            $pengajuanLahir->tgl_pengajuan = now();
            $pengajuanLahir->status = 'pending';
            $pengajuanLahir->petugas = Auth::user()->username;

            $pengajuanLahir->surat_pengantar = $r->file('surat_pengantar') ? $this->uploadLahir($r->file('surat_pengantar'), 'nik_surat_pengantar') : null;
            $pengajuanLahir->surat_lahir = $r->file('surat_lahir') ? $this->uploadLahir($r->file('surat_lahir'), 'nik_surat_lahir') : null;
            $pengajuanLahir->kk = $r->file('kk') ? $this->uploadLahir($r->file('kk'), 'nik_kk') : null;
            $pengajuanLahir->ktp_ayah = $r->file('ktp_ayah') ? $this->uploadLahir($r->file('ktp_ayah'), 'nik_ktp_ayah') : null;
            $pengajuanLahir->ktp_ibu = $r->file('ktp_ibu') ? $this->uploadLahir($r->file('ktp_ibu'), 'nik_ktp_ibu') : null;
            $pengajuanLahir->buku_nikah = $r->file('buku_nikah') ? $this->uploadLahir($r->file('buku_nikah'), 'nik_buku_nikah') : null;
            $pengajuanLahir->lainnya = $r->file('lainnya') ? $this->uploadLahir($r->file('lainnya'), 'nik_lainnya') : null;

            $pengajuanLahir->no_hp = $r->input('no_hp');
            $pengajuanLahir->no_kk = $r->input('no_kk');
            $pengajuanLahir->nama_anak = $r->input('nama_anak');
            $pengajuanLahir->jk_anak = $r->input('jk_anak');
            $pengajuanLahir->tgl_lahir = $r->input('tgl_lahir');
            $pengajuanLahir->jenis_kelahiran = $r->input('jenis_kelahiran');
            $pengajuanLahir->anak_ke = $r->input('anak_ke');
            $pengajuanLahir->berat = $r->input('berat');
            $pengajuanLahir->panjang = $r->input('panjang');
            $pengajuanLahir->nik_ibu = $r->input('nik_ibu');
            $pengajuanLahir->nama_ibu = $r->input('nama_ibu');
            $pengajuanLahir->nik_ayah = $r->input('nik_ayah');
            $pengajuanLahir->nama_ayah = $r->input('nama_ayah');
            $pengajuanLahir->detail = $r->input('detail');

            $pengajuanLahir->save();

            return redirect()->route('pengajuan-lahir')->with('success', 'Pengajuan Kelahiran berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pengajuan Kelahiran. Silakan coba lagi.');
        }
    }

    private function uploadLahir($file, $prefix)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = "{$prefix}_{$file->hashName()}";
        $path = $file->storeAs('uploads/aktalahir', $fileName, 'public');

        return basename($path);
    }

    public function detaillahir($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanAktaLahir::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'pending')
            ->first();

        return view('desa.pengajuan.lahir.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function hapuslahir($id)
    {
        try {
            $pengajuanLahir = PengajuanAktaLahir::findOrFail($id);

            $this->hapusFileLahir($pengajuanLahir->surat_pengantar);
            $this->hapusFileLahir($pengajuanLahir->surat_lahir);
            $this->hapusFileLahir($pengajuanLahir->kk);
            $this->hapusFileLahir($pengajuanLahir->ktp_ayah);
            $this->hapusFileLahir($pengajuanLahir->ktp_ibu);
            $this->hapusFileLahir($pengajuanLahir->buku_nikah);
            $this->hapusFileLahir($pengajuanLahir->lainnya);

            $pengajuanLahir->delete();

            return redirect()->route('pengajuan-lahir')->with('success', 'Data pengajuan Akta Kelahiran berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengajuan Akta Kelahiran. Silahkan coba lagi.');
        }
    }

    private function hapusFileLahir($file)
    {
        if ($file && Storage::exists('public/uploads/aktalahir/' . $file)) {
            Storage::delete('public/uploads/aktalahir/' . $file);
        }
    }

    public function kematian()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanKematian::where('petugas', $user->username)
            ->where('status', 'pending')
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

    public function tambahkematian()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.kematian.tambah')->with([
            'user' => $user,
            'profil' => optional($profil),
        ]);
    }

    public function simpankematian(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'no_hp' => 'required|numeric',
            'nik_pelapor' => 'required|numeric',
            'nama_pelapor' => 'required|string',
            'nik_mati' => 'required|numeric',
            'nama_mati' => 'required|string',
            'ktp_pelapor' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'ktp_mati' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'kk' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'surat_kuning' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'surat_mati_desa' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'formulir_mati' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'image' => 'Berkas :attribute harus berupa gambar.',
            'mimes' => 'Berkas :attribute harus memiliki format jpeg, png, jpg, atau gif, pdf.',
            'max' => 'Ukuran berkas :attribute tidak boleh lebih dari 2 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuanMati = new PengajuanKematian();

            $latestNoreg = PengajuanKematian::whereDate('tgl_pengajuan', now()->toDateString())->latest('noreg')->first();
            $nomorUrut = $latestNoreg ? (int)substr($latestNoreg->noreg, -3) : 0;
            $nomorUrut = ($nomorUrut % 999) + 1;
            $noreg = '1219/didesa/kematian/' . now()->format('dmY') . '/' . sprintf('%03d', $nomorUrut);

            $pengajuanMati->noreg = $noreg;

            $pengajuanMati->tgl_pengajuan = now();
            $pengajuanMati->status = 'pending';
            $pengajuanMati->petugas = Auth::user()->username;

            $pengajuanMati->ktp_pelapor = $r->file('ktp_pelapor') ? $this->uploadKematian($r->file('ktp_pelapor'), 'nik_ktp_pelapor') : null;
            $pengajuanMati->ktp_mati = $r->file('ktp_mati') ? $this->uploadKematian($r->file('ktp_mati'), 'nik_ktp_mati') : null;
            $pengajuanMati->kk = $r->file('kk') ? $this->uploadKematian($r->file('kk'), 'nik_kk') : null;
            $pengajuanMati->surat_kuning = $r->file('surat_kuning') ? $this->uploadKematian($r->file('surat_kuning'), 'nik_surat_kuning') : null;
            $pengajuanMati->surat_mati_desa = $r->file('surat_mati_desa') ? $this->uploadKematian($r->file('surat_mati_desa'), 'nik_surat_mati_desa') : null;
            $pengajuanMati->formulir_mati = $r->file('formulir_mati') ? $this->uploadKematian($r->file('formulir_mati'), 'nik_formulir_mati') : null;

            $pengajuanMati->no_hp = $r->input('no_hp');
            $pengajuanMati->nik_pelapor = $r->input('nik_pelapor');
            $pengajuanMati->nama_pelapor = $r->input('nama_pelapor');
            $pengajuanMati->nik_mati = $r->input('nik_mati');
            $pengajuanMati->nama_mati = $r->input('nama_mati');

            $pengajuanMati->save();

            return redirect()->route('pengajuan-kematian')->with('success', 'Pengajuan Kematian berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pengajuan Kematian. Silakan coba lagi.');
        }
    }

    private function uploadKematian($file, $prefix)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = "{$prefix}_{$file->hashName()}";
        $path = $file->storeAs('uploads/aktakematian', $fileName, 'public');

        return basename($path);
    }

    public function detailkematian($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanKematian::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'pending')
            ->first();

        return view('desa.pengajuan.kematian.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function hapuskematian($id)
    {
        try {
            $pengajuanKematian = PengajuanKematian::findOrFail($id);

            // Hapus berkas kematian
            $this->hapusFileKematian($pengajuanKematian->ktp_pelapor);
            $this->hapusFileKematian($pengajuanKematian->ktp_mati);
            $this->hapusFileKematian($pengajuanKematian->kk);
            $this->hapusFileKematian($pengajuanKematian->surat_kuning);
            $this->hapusFileKematian($pengajuanKematian->surat_mati_desa);
            $this->hapusFileKematian($pengajuanKematian->formulir_mati);

            // Hapus data pengajuan kematian
            $pengajuanKematian->delete();

            return redirect()->route('pengajuan-kematian')->with('success', 'Data pengajuan Akta Kematian berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengajuan Akta Kematian. Silahkan coba lagi.');
        }
    }

    private function hapusFileKematian($file)
    {
        if ($file && Storage::exists('public/uploads/aktakematian/' . $file)) {
            Storage::delete('public/uploads/aktakematian/' . $file);
        }
    }

    public function pindah()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        $berkas = PengajuanSuratPindah::where('petugas', $user->username)
            ->where('status', 'pending')
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

    public function tambahpindah()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();

        return view('desa.pengajuan.pindah.tambah')->with([
            'user' => $user,
            'profil' => optional($profil),
        ]);
    }

    public function simpanpindah(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'no_hp' => 'required|numeric',
            'nik_pelapor' => 'required|numeric',
            'nama_pelapor' => 'required|string',
            'alamat_old' => 'required|string',
            'alamat_new' => 'required|string',
            'ktp' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'kk' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
            'surat_desa' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:2048',
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'string' => 'Kolom :attribute harus berupa teks.',
            'image' => 'Berkas :attribute harus berupa gambar.',
            'mimes' => 'Berkas :attribute harus memiliki format jpeg, png, jpg, atau gif, pdf.',
            'max' => 'Ukuran berkas :attribute tidak boleh lebih dari 2 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $pengajuanPindah = new PengajuanSuratPindah();

            $latestNoreg = PengajuanSuratPindah::whereDate('tgl_pengajuan', now()->toDateString())->latest('noreg')->first();
            $nomorUrut = $latestNoreg ? (int)substr($latestNoreg->noreg, -3) : 0;
            $nomorUrut = ($nomorUrut % 999) + 1;
            $noreg = '1219/didesa/pindah/' . now()->format('dmY') . '/' . sprintf('%03d', $nomorUrut);

            $pengajuanPindah->noreg = $noreg;

            $pengajuanPindah->tgl_pengajuan = now();
            $pengajuanPindah->status = 'pending';
            $pengajuanPindah->petugas = Auth::user()->username;

            $pengajuanPindah->ktp = $r->file('ktp') ? $this->uploadPindah($r->file('ktp'), 'nik_ktp_pelapor_pindah') : null;
            $pengajuanPindah->kk = $r->file('kk') ? $this->uploadPindah($r->file('kk'), 'nik_kk_pindah') : null;
            $pengajuanPindah->surat_desa = $r->file('surat_desa') ? $this->uploadPindah($r->file('surat_desa'), 'nik_surat_desa_pindah') : null;

            $pengajuanPindah->no_hp = $r->input('no_hp');
            $pengajuanPindah->nik_pelapor = $r->input('nik_pelapor');
            $pengajuanPindah->nama_pelapor = $r->input('nama_pelapor');
            $pengajuanPindah->alamat_old = $r->input('alamat_old');
            $pengajuanPindah->alamat_new = $r->input('alamat_new');

            $pengajuanPindah->save();

            return redirect()->route('pengajuan-pindah')->with('success', 'Pengajuan Pindah berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan pengajuan Pindah. Silakan coba lagi.');
        }
    }

    private function uploadPindah($file, $prefix)
    {
        $extension = $file->getClientOriginalExtension();
        $fileName = "{$prefix}_{$file->hashName()}";
        $path = $file->storeAs('uploads/suratpindah', $fileName, 'public');

        return basename($path);
    }

    public function detailpindah($id)
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = ProfilModel::where('kode_user', $kode_user)->first();
        $berkas = PengajuanSuratPindah::where('id', $id)
            ->where('petugas', $user->username)
            ->where('status', 'pending')
            ->first();

        return view('desa.pengajuan.pindah.detail')->with([
            'user' => $user,
            'profil' => optional($profil),
            'berkas' => $berkas,
        ]);
    }

    public function hapuspindah($id)
    {
        try {
            $pengajuanPindah = PengajuanSuratPindah::findOrFail($id);

            $this->hapusFilePindah($pengajuanPindah->ktp);
            $this->hapusFilePindah($pengajuanPindah->kk);
            $this->hapusFilePindah($pengajuanPindah->surat_desa);

            $pengajuanPindah->delete();

            return redirect()->route('pengajuan-pindah')->with('success', 'Data pengajuan Pindah berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data pengajuan Pindah. Silakan coba lagi.');
        }
    }

    private function hapusFilePindah($file)
    {
        if ($file && Storage::exists('public/uploads/suratpindah/' . $file)) {
            Storage::delete('public/uploads/suratpindah/' . $file);
        }
    }
}
