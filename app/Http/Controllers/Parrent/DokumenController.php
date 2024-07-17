<?php

namespace App\Http\Controllers\Parrent;

use App\Http\Controllers\Controller;
use App\Models\Desa\ProfilModel as DesaProfilModel;
use App\Models\Dokumen;
use App\Models\ProfilModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profil_op = ProfilModel::where('kode_user', $user->kode_user)->first();

        $dokumen = Dokumen::paginate(10);

        return view('parrent.dokumen.dashboard')->with([
            'user' => $user,
            'profil_op' => $profil_op,
            'dokumen' => $dokumen
        ]);
    }

    public function tambah(Request $r)
    {
        try {
            $this->validate($r, [
                'name' => 'required|string|max:255',
                'file' => 'required|file|max:2048', // 2048 KB = 2 MB
            ]);

            if ($r->hasFile('file')) {
                $file = $r->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/dokumen', $fileName);

                $dokumen = new Dokumen();
                $dokumen->name = $r->input('name');
                $dokumen->file = $fileName;
                $dokumen->save();

                return redirect()->back()->with('success', 'Dokumen berhasil ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'File tidak ditemukan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan dokumen.');
        }
    }

    public function edit(Request $r, $id)
    {
        try {
            $this->validate($r, [
                'name' => 'required|string|max:255',
                'file' => 'nullable|file|max:2048', // 2048 KB = 2 MB
            ]);

            $dokumen = Dokumen::findOrFail($id);

            if ($r->hasFile('file')) {
                if ($dokumen->file) {
                    Storage::delete('public/dokumen/' . $dokumen->file);
                }

                $file = $r->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/dokumen', $fileName);

                $dokumen->file = $fileName;
            }

            $dokumen->name = $r->input('name');
            $dokumen->save();

            return redirect()->back()->with('success', 'Dokumen berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui dokumen.');
        }
    }

    public function hapus($id)
    {
        try {
            $dokumen = Dokumen::findOrFail($id);

            if ($dokumen->file) {
                Storage::delete('public/dokumen/' . $dokumen->file);
            }

            $dokumen->delete();

            return redirect()->back()->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus dokumen.');
        }
    }

    public function desa()
    {
        $user = Auth::user();
        $kode_user = $user->kode_user;
        $profil = DesaProfilModel::where('kode_user', $kode_user)->first();

        $dokumen = Dokumen::paginate(10);

        return view('parrent.dokumen.dashboard')->with([
            'user' => $user,
            'profil' => $profil,
            'dokumen' => $dokumen
        ]);
    }
}
