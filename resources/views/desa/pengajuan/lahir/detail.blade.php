@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @if (request()->is('selesai/lahir/detail/' . $berkas->id))
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Pengajuan Berkas Selesai
                        </div>
                    @elseif (request()->is('ditolak/lahir/detail/' . $berkas->id))
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Pengajuan Berkas Ditolak
                        </div>
                    @else
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Pengajuan Berkas
                        </div>
                    @endif
                    <h2 class="page-title">
                        Detail Pengajuan Akta Kelahiran {{ $berkas->nama_anak }}
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
                        @if ($user->level == 3)
                            <h4 class="card-title">Data {{ $user->name }}</h4>
                        @else
                            <h4 class="card-title">Data {{ $petugas->name }}</h4>
                        @endif
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
                                        placeholder="Masukkan Nomor Telefon Pelapor" value="{{ $berkas->no_hp }}" disabled>
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
                                        placeholder="Masukkan Nomor Kartu Keluarga Pelapor" value="{{ $berkas->no_kk }}"
                                        disabled>
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
                                    placeholder="Masukkan Nama Anak" value="{{ $berkas->nama_anak }}" disabled>
                                @error('nama_anak')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label required">Jenis Kelamin Anak</div>
                                <select name="jk_anak" id="jk_anak"
                                    class="form-select @error('jk_anak') is-invalid @enderror" disabled>
                                    <option value="">Pilih Jenis Kelamin Anak</option>
                                    <option value="Laki-Laki"
                                        {{ $berkas->jk_anak == 'Laki-Laki' ? 'selected' : (old('jk_anak') == 'Laki-Laki' ? 'selected' : '') }}>
                                        Laki-Laki</option>
                                    <option value="Perempuan"
                                        {{ $berkas->jk_anak == 'Perempuan' ? 'selected' : (old('jk_anak') == 'Perempuan' ? 'selected' : '') }}>
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
                                    value="{{ $berkas->tgl_lahir }}" disabled>
                                @error('tgl_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label required">Jenis Kelahiran</div>
                                <select name="jenis_kelahiran" id="jenis_kelahiran"
                                    class="form-select @error('jenis_kelahiran') is-invalid @enderror" disabled>
                                    <option value="Tunggal"
                                        {{ $berkas->jenis_kelahiran == 'Tunggal' ? 'selected' : (old('jenis_kelahiran') == 'Tunggal' ? 'selected' : '') }}>
                                        Tunggal</option>
                                    <option value="Kembar 2"
                                        {{ $berkas->jenis_kelahiran == 'Kembar 2' ? 'selected' : (old('jenis_kelahiran') == 'Kembar 2' ? 'selected' : '') }}>
                                        Kembar 2</option>
                                    <option value="Kembar 3"
                                        {{ $berkas->jenis_kelahiran == 'Kembar 3' ? 'selected' : (old('jenis_kelahiran') == 'Kembar 3' ? 'selected' : '') }}>
                                        Kembar 3</option>
                                    <option value="Kembar 4"
                                        {{ $berkas->jenis_kelahiran == 'Kembar 4' ? 'selected' : (old('jenis_kelahiran') == 'Kembar 4' ? 'selected' : '') }}>
                                        Kembar 4</option>
                                    <option value="Kembar 5"
                                        {{ $berkas->jenis_kelahiran == 'Kembar 5' ? 'selected' : (old('jenis_kelahiran') == 'Kembar 5' ? 'selected' : '') }}>
                                        Kembar 5</option>
                                    <option value="Lainnya"
                                        {{ $berkas->jenis_kelahiran == 'Lainnya' ? 'selected' : (old('jenis_kelahiran') == 'Lainnya' ? 'selected' : '') }}>
                                        Lainnya</option>
                                </select>
                                @error('jenis_kelahiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label required">Anak Ke</div>
                                <input type="number" name="anak_ke" id="anak_ke"
                                    class="form-control @error('anak_ke') is-invalid @enderror" placeholder="Anak ke ..."
                                    value="{{ $berkas->anak_ke }}" disabled>
                                @error('anak_ke')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label required">Berat (gram)</div>
                                <input type="number" name="berat" id="berat"
                                    class="form-control @error('berat') is-invalid @enderror" placeholder="cth: 200"
                                    value="{{ $berkas->berat }}" disabled>
                                @error('berat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label required">Panjang (cm)</div>
                                <input type="number" name="panjang" id="panjang"
                                    class="form-control @error('panjang') is-invalid @enderror" placeholder="cth: 30"
                                    value="{{ $berkas->panjang }}" disabled>
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
                                        placeholder="Masukkan NIK Ibu" value="{{ $berkas->nik_ibu }}" disabled>
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
                                        placeholder="Masukan Nama Ibu" value="{{ $berkas->nama_ibu }}" disabled>
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
                                        placeholder="Masukkan NIK Ayah" value="{{ $berkas->nik_ayah }}" disabled>
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
                                        placeholder="Masukkan Nama Ayah" value="{{ $berkas->nama_ayah }}" disabled>
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Detail Pengajuan</label>
                                    <textarea name="detail" id="" cols="30" rows="5"
                                        class="form-control @error('detail') is-invalid @enderror" disabled>{{ $berkas->detail }}</textarea>
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
                        <h4 class="card-title">Berkas Persyaratan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-6 mb-3">
                                <div class="form-label">Surat Pengantar</div>
                                @if ($berkas->surat_pengantar == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->surat_pengantar) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->surat_pengantar) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->surat_pengantar) }}')">Cetak</button>
                                @endif
                            </div> --}}
                            <div class="col-6 mb-3">
                                <div class="form-label">Surat Kelahiran</div>
                                @if ($berkas->surat_lahir == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->surat_lahir) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->surat_lahir) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->surat_lahir) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Kartu Keluarga</div>
                                @if ($berkas->kk == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->kk) }}" target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->kk) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->kk) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">KTP Ayah</div>
                                @if ($berkas->ktp_ayah == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->ktp_ayah) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->ktp_ayah) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->ktp_ayah) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">KTP Ibu</div>
                                @if ($berkas->ktp_ibu == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->ktp_ibu) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->ktp_ibu) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->ktp_ibu) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Buku Nikah / Akta Pernikahan</div>
                                @if ($berkas->buku_nikah == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->buku_nikah) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->buku_nikah) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->buku_nikah) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 1</div>
                                @if ($berkas->f201 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->f201) }}" target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->f201) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->f201) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 2</div>
                                @if ($berkas->f201_hal2 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal2) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal2) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal2) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 3</div>
                                @if ($berkas->f201_hal3 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal3) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal3) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal3) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 4</div>
                                @if ($berkas->f201_hal4 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal4) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal4) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->f201_hal4) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Berkas Lainnya (jika diperlukan)</div>
                                    @if ($berkas->lainnya == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/aktalahir/' . $berkas->lainnya) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/aktalahir/' . $berkas->lainnya) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/aktalahir/' . $berkas->lainnya) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <a href="{{ url()->previous() }}" class="btn btn-info">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function printFile(fileUrl) {
                // Membuka jendela pencetakan browser
                var printWindow = window.open(fileUrl, '_blank');
                printWindow.print();
            }
        </script>
    @endsection
