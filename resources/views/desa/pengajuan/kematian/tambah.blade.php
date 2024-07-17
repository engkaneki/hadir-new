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
                        Buat Pengajuan Akta Kematian
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
                <form action="{{ url('pengajuan/kematian/simpan') }}" method="post" enctype="multipart/form-data">
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
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="card-title">Data Keluarga yang Meninggal</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">NIK Keluarga yang Meninggal</label>
                                        <input type="number" name="nik_mati" id=""
                                            class="form-control @error('nik_mati') is-invalid @enderror"
                                            placeholder="Masukkan NIK Keluarga yang Meninggal"
                                            value="{{ old('nik_mati') }}">
                                        @error('nik_mati')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Keluarga yang Meninggal</label>
                                        <input type="text" name="nama_mati" id=""
                                            class="form-control @error('nama_mati') is-invalid @enderror"
                                            placeholder="Masukan Nama Keluarga yang Meninggal"
                                            value="{{ old('nama_mati') }}">
                                        @error('nama_mati')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Berkas Persyaratan (Pastikan ukuran file kurang dari 1mb)</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-label">KTP Pelapor</div>
                                    <input type="file" name="ktp_pelapor" id="" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">KTP Keluarga yang Meninggal</div>
                                    <input type="file" name="ktp_mati" id="" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Kartu Keluarga yang Meninggal</div>
                                    <input type="file" name="kk" id="" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Surat Keterangan Kematian dari Desa (Surat
                                        Kuning)</div>
                                    <input type="file" name="surat_kuning" id="" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Surat Keterangan Kematian dari Rumah Sakit / Desa</div>
                                    <input type="file" name="surat_mati_desa" id="" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">SPTJM Kematian</div>
                                    <input type="file" name="formulir_mati" id="" class="form-control"
                                        accept="image/*">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Berkas F-2.01</div>
                                    <input type="file" name="f201" id="" class="form-control"
                                        accept="image/*">
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
