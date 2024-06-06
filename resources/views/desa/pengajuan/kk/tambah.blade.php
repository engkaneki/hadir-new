@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Pengajuan Berkas
                    </div>
                    <h2 class="page-title">
                        Buat Pengajuan Kartu Keluarga
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tampilkan pesan kesalahan jika ada -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data {{ $user->name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Email Desa</div>
                                    @if ($profil->email == null)
                                        <input type="text" class="form-control" placeholder="Belum mengisi email"
                                            disabled>
                                    @else
                                        <input type="text" class="form-control" value="{{ $profil->email }}" disabled>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">No. Telefon Desa</div>
                                    @if ($profil->no_hp == null)
                                        <input type="number" name="" id="" class="form-control"
                                            placeholder="Belum mengisi No. Telefon" disabled>
                                    @else
                                        <input type="number" name="" id="" class="form-control"
                                            value="{{ $profil->no_hp }}" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ url('pengajuan/kk/simpan') }}" method="post" class="card mt-3"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Data Pelapor</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label required">No. Telefon</label>
                                    <input type="number" name="no_hp" id=""
                                        class="form-control @error('no_hp') is-invalid @enderror"
                                        placeholder="Masukkan Nomor Telefon Pelapor" value="{{ old('no_hp') }}">
                                    @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label required">NIK Suami</label>
                                    <input type="text" name="nik_suami" id=""
                                        class="form-control @error('nik_suami') is-invalid @enderror"
                                        placeholder="Masukkan NIK Suami" value="{{ old('nik_suami') }}">
                                    @error('nik_suami')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Suami</label>
                                    <input type="text" name="nama_suami" id=""
                                        class="form-control @error('nama_suami') is-invalid @enderror"
                                        placeholder="Masukkan Nama Suami" value="{{ old('nama_suami') }}">
                                    @error('nama_suami')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label required">NIK Istri</label>
                                    <input type="number" name="nik_istri" id=""
                                        class="form-control @error('nik_istri') is-invalid @enderror"
                                        placeholder="Masukkan NIK Istri" value="{{ old('nik_istri') }}">
                                    @error('nik_istri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nama Istri</label>
                                    <input type="text" name="nama_istri" id=""
                                        class="form-control @error('nama_istri') is-invalid @enderror"
                                        placeholder="Masukan Nama Istri" value="{{ old('nama_istri') }}">
                                    @error('nama_istri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Detail Pengajuan</label>
                                    <textarea name="det" id="" cols="30" rows="5"
                                        class="form-control @error('det') is-invalid @enderror">{{ old('det') }}</textarea>
                                    @error('det')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Berkas Persyaratan (Pastikan ukuran file kurang dari 1mb)</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Kartu Keluarga Orang Tua Suami</div>
                                    <input type="file" name="kk_suami" id="" class="form-control"
                                        accept="image/*">
                                    @error('kk_suami')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Kartu Keluarga Orang Tua Istri</div>
                                    <input type="file" name="kk_istri" id="" class="form-control"
                                        accept="image/*">
                                    @error('kk_istri')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">KTP Suami</div>
                                    <input type="file" name="ktp_suami" id="" class="form-control"
                                        accept="image/*">
                                    @error('ktp_suami')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">KTP Istri</div>
                                    <input type="file" name="ktp_istri" id="" class="form-control"
                                        accept="image/*">
                                    @error('ktp_istri')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Buku Nikah / Akta Perkawinan</div>
                                    <input type="file" name="buku_nikah" id="" class="form-control"
                                        accept="image/*">
                                    @error('buku_nikah')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Buku Nikah / Akta Perkawinan Orang Tua Suami</div>
                                    <input type="file" name="buku_nikah_ortu" id="" class="form-control"
                                        accept="image/*">
                                    @error('buku_nikah_ortu')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Buku Nikah / Akta Perkawinan Orang Tua Istri</div>
                                    <input type="file" name="buku_nikah_ortu2" id="" class="form-control"
                                        accept="image/*">
                                    @error('buku_nikah_ortu2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Surat Pindah (jika Suami atau Istri dari
                                        Desa/Kecamata/Kabupaten/Provinsi lain)</div>
                                    <input type="file" name="surat_pindah" id="" class="form-control"
                                        accept="image/*">
                                    @error('surat_pindah')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Berkas Lainnya (jika diperlukan)</div>
                                    <input type="file" name="lainnya" id="" class="form-control"
                                        accept="image/*">
                                    @error('lainnya')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                            <button type="submit" class="btn btn-primary ms-auto">Kirim Pengajuan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
