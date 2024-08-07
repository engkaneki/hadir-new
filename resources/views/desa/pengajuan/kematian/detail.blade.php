@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @if (request()->is('selesai/kematian/detail/' . $berkas->id))
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Pengajuan Berkas Selesai
                        </div>
                    @elseif (request()->is('ditolak/kematian/detail/' . $berkas->id))
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
                        Detail Pengajuan Akta Kematian {{ $berkas->nama_mati }}
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
                                        placeholder="Masukkan Nomor Telefon Pelapor" value="{{ $berkas->no_hp }}" disabled>
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
                                        placeholder="Masukkan NIK Pelapor" value="{{ $berkas->nik_pelapor }}" disabled>
                                    @error('nik_pelapor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label required">Nama Pelapor</div>
                                <input type="text" name="nama_pelapor" id="nama_pelapor"
                                    class="form-control @error('nama_pelapor') is-invalid @enderror"
                                    placeholder="Masukkan Nama Pelapor" value="{{ $berkas->nama_pelapor }}" disabled>
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
                                        placeholder="Masukkan NIK Keluarga yang Meninggal" value="{{ $berkas->nik_mati }}"
                                        disabled>
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
                                        placeholder="Masukan Nama Keluarga yang Meninggal" value="{{ $berkas->nama_mati }}"
                                        disabled>
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
                        <h4 class="card-title">Berkas Persyaratan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="form-label">KTP Pelapor</div>
                                @if ($berkas->ktp_pelapor == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->ktp_pelapor) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->ktp_pelapor) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->ktp_pelapor) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">KTP Keluarga yang Meninggal</div>
                                @if ($berkas->ktp_mati == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->ktp_mati) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->ktp_mati) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->ktp_mati) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Kartu Keluarga yang Meninggal</div>
                                @if ($berkas->kk == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->kk) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->kk) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->kk) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Surat Keterangan Kematian dari Desa (Surat Kuning)
                                </div>
                                @if ($berkas->surat_kuning == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->surat_kuning) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->surat_kuning) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->surat_kuning) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Surat Keterangan Kematian dari Rumah Sakit / Desa</div>
                                @if ($berkas->surat_mati_desa == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->surat_mati_desa) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->surat_mati_desa) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->surat_mati_desa) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">SPTJM Kematian</div>
                                @if ($berkas->formulir_mati == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->formulir_mati) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->formulir_mati) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->formulir_mati) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 1</div>
                                @if ($berkas->f201 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->f201) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->f201) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->f201) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 2</div>
                                @if ($berkas->f201_hal2 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal2) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal2) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal2) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 3</div>
                                @if ($berkas->f201_hal3 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal3) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal3) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal3) }}')">Cetak</button>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <div class="form-label">Berkas F-2.01 Halaman 4</div>
                                @if ($berkas->f201_hal4 == null)
                                    <span class="badge bg-red">Tidak ada Berkas</span>
                                @else
                                    <a data-fslightbox="gallery"
                                        href="{{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal4) }}"
                                        target="_blank">
                                        <!-- Photo -->
                                        <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                            style="background-image: url({{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal4) }})">
                                        </div>
                                    </a>
                                    <button class="btn btn-success mt-3"
                                        onclick="printFile('{{ asset('storage/uploads/aktakematian/' . $berkas->f201_hal4) }}')">Cetak</button>
                                @endif
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
