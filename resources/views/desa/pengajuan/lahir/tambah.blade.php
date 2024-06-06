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
                        Buat Pengajuan Akta Kelahiran
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
                <form action="{{ url('pengajuan/lahir/simpan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title">Data Anak
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
                                        <label class="form-label required">No. Kartu Keluarga</label>
                                        <input type="number" name="no_kk" id=""
                                            class="form-control @error('no_kk') is-invalid @enderror"
                                            placeholder="Masukkan Nomor Kartu Keluarga Pelapor" value="{{ old('no_kk') }}">
                                        @error('no_kk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Nama Anak</div>
                                    <input type="text" name="nama_anak" id="nama_anak"
                                        class="form-control @error('nama_anak') is-invalid @enderror"
                                        placeholder="Masukkan Nama Anak" value="{{ old('nama_anak') }}">
                                    @error('nama_anak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Jenis Kelamin Anak</div>
                                    <select name="jk_anak" id="jk_anak"
                                        class="form-select @error('jk_anak') is-invalid @enderror">
                                        <option value="">Pilih Jenis Kelamin Anak</option>
                                        <option value="Laki-Laki" {{ old('jk_anak') == 'Laki-Laki' ? 'selected' : '' }}>
                                            Laki-Laki</option>
                                        <option value="Perempuan" {{ old('jk_anak') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jk_anak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Tanggal Lahir</div>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir"
                                        class="form-control @error('tgl_lahir') is-invalid @enderror"
                                        value="{{ old('tgl_lahir') }}">
                                    @error('tgl_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Jenis Kelahiran</div>
                                    <select name="jenis_kelahiran" id="jenis_kelahiran"
                                        class="form-select @error('jenis_kelahiran') is-invalid @enderror">
                                        <option value="Tunggal"
                                            {{ old('jenis_kelahiran') == 'Tunggal' ? 'selected' : '' }}>Tunggal</option>
                                        <option value="Kembar 2"
                                            {{ old('jenis_kelahiran') == 'Kembar 2' ? 'selected' : '' }}>Kembar 2</option>
                                        <option value="Kembar 3"
                                            {{ old('jenis_kelahiran') == 'Kembar 3' ? 'selected' : '' }}>Kembar 3</option>
                                        <option value="Kembar 4"
                                            {{ old('jenis_kelahiran') == 'Kembar 4' ? 'selected' : '' }}>Kembar 4</option>
                                        <option value="Kembar 5"
                                            {{ old('jenis_kelahiran') == 'Kembar 5' ? 'selected' : '' }}>Kembar 5</option>
                                        <option value="Lainnya"
                                            {{ old('jenis_kelahiran') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('jenis_kelahiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Anak Ke</div>
                                    <input type="number" name="anak_ke" id="anak_ke"
                                        class="form-control @error('anak_ke') is-invalid @enderror"
                                        placeholder="Anak ke ..." value="{{ old('anak_ke') }}">
                                    @error('anak_ke')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Berat (gram)</div>
                                    <input type="number" name="berat" id="berat"
                                        class="form-control @error('berat') is-invalid @enderror" placeholder="cth: 200"
                                        value="{{ old('berat') }}">
                                    @error('berat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label required">Panjang (cm)</div>
                                    <input type="number" name="panjang" id="panjang"
                                        class="form-control @error('panjang') is-invalid @enderror" placeholder="cth: 30"
                                        value="{{ old('panjang') }}">
                                    @error('panjang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <div class="card-title">Data Orang Tua</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">NIK Ibu</label>
                                        <input type="number" name="nik_ibu" id=""
                                            class="form-control @error('nik_ibu') is-invalid @enderror"
                                            placeholder="Masukkan NIK Ibu" value="{{ old('nik_ibu') }}">
                                        @error('nik_ibu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Ibu</label>
                                        <input type="text" name="nama_ibu" id=""
                                            class="form-control @error('nama_ibu') is-invalid @enderror"
                                            placeholder="Masukan Nama Ibu" value="{{ old('nama_ibu') }}">
                                        @error('nama_ibu')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">NIK Ayah</label>
                                        <input type="text" name="nik_ayah" id=""
                                            class="form-control @error('nik_ayah') is-invalid @enderror"
                                            placeholder="Masukkan NIK Ayah" value="{{ old('nik_ayah') }}">
                                        @error('nik_ayah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nama Ayah</label>
                                        <input type="text" name="nama_ayah" id=""
                                            class="form-control @error('nama_ayah') is-invalid @enderror"
                                            placeholder="Masukkan Nama Ayah" value="{{ old('nama_ayah') }}">
                                        @error('nama_ayah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Detail Pengajuan</label>
                                        <textarea name="detail" id="" cols="30" rows="5"
                                            class="form-control @error('detail') is-invalid @enderror">{{ old('detail') }}</textarea>
                                        @error('detail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                {{-- <div class="col-6 mb-3">
                                    <div class="form-label">Surat Pengantar</div>
                                    <input type="file" name="surat_pengantar" id="" class="form-control">
                                </div> --}}
                                <div class="col-6 mb-3">
                                    <div class="form-label">Surat Kelahiran</div>
                                    <input type="file" name="surat_lahir" id="" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Kartu Keluarga</div>
                                    <input type="file" name="kk" id="" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">KTP Ayah</div>
                                    <input type="file" name="ktp_ayah" id="" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">KTP Ibu</div>
                                    <input type="file" name="ktp_ibu" id="" class="form-control">
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-label">Buku Nikah / Akta Pernikahan</div>
                                    <input type="file" name="buku_nikah" id="" class="form-control">
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="form-label">Berkas Lainnya (jika diperlukan)</div>
                                        <input type="file" name="lainnya" id="" class="form-control">
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
                    </div>
                </form>
            </div>
        </div>
    @endsection
