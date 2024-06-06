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
                        Buat Pengajuan Surat Pindah
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
                <form action="{{ url('pengajuan/pindah/simpan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Data Pelapor
                            </h4>
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
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">NIK Pelapor</label>
                                        <input type="number" name="nik_pelapor" id=""
                                            class="form-control @error('nik_pelapor') is-invalid @enderror"
                                            placeholder="Masukkan NIK Pelapor" value="{{ old('nik_pelapor') }}">
                                        @error('nik_pelapor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Nama Pelapor</div>
                                    <input type="text" name="nama_pelapor" id="nama_pelapor"
                                        class="form-control @error('nama_pelapor') is-invalid @enderror"
                                        placeholder="Masukkan Nama Pelapor" value="{{ old('nama_pelapor') }}">
                                    @error('nama_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Alamat saat ini</div>
                                    <textarea name="alamat_old" id="" cols="30" rows="5"
                                        class="form-control @error('alamat_old') is-invalid @enderror">{{ old('alamat_old') }}</textarea>
                                    @error('alamat_old')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Alamat baru</div>
                                    <textarea name="alamat_new" id="" cols="30" rows="5"
                                        class="form-control @error('alamat_new') is-invalid @enderror">{{ old('alamat_new') }}</textarea>
                                    @error('alamat_new')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Berkas Persyaratan (Pastikan ukuran file kurang dari 2mb)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-label">KTP Pelapor</div>
                                    <input type="file" name="ktp" id="" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">KK Pelapor</div>
                                    <input type="file" name="kk" id="" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Surat Keterangan Pindah dari Desa</div>
                                    <input type="file" name="surat_desa" id="" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <a href="{{ url()->previous() }}" class="btn btn-danger">Batal</a>
                                <button type="submit" class="btn btn-primary ms-auto">Kirim Pengajuan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection
