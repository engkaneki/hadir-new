@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    @if (request()->is('selesai/kk/detail/' . $berkas->id))
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Pengajuan Berkas Selesai
                        </div>
                    @elseif (request()->is('ditolak/kk/detail/' . $berkas->id))
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
                        Detail Pengajuan Kartu Keluarga {{ $berkas->nama_suami }}
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
                        <h4 class="card-title">Data Pelapor</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">No. Register</div>
                                    <input type="text" class="form-control" value="{{ $berkas->noreg }}" disabled>
                                </div>
                            </div>
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
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label required">NIK Suami</label>
                                    <input type="text" name="nik_suami" id=""
                                        class="form-control @error('nik_suami') is-invalid @enderror"
                                        placeholder="Masukkan NIK Suami" value="{{ $berkas->nik_suami }}" disabled>
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
                                        placeholder="Masukkan Nama Suami" value="{{ $berkas->nama_suami }}" disabled>
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
                                        placeholder="Masukkan NIK Istri" value="{{ $berkas->nik_istri }}" disabled>
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
                                        placeholder="Masukan Nama Istri" value="{{ $berkas->nama_istri }}" disabled>
                                    @error('nama_istri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label required">Detail Pengajuan</label>
                                    <textarea name="det" id="" cols="30" rows="5"
                                        class="form-control @error('det') is-invalid @enderror" disabled>{{ $berkas->detail }}</textarea>
                                    @error('det')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Berkas Persyaratan</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Kartu Keluarga Orang Tua Suami</div>
                                    @if ($berkas->kk_suami == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->kk_suami) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->kk_suami) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->kk_suami) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Kartu Keluarga Orang Tua Istri</div>
                                    @if ($berkas->kk_istri == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->kk_istri) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->kk_istri) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->kk_istri) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">KTP Suami</div>
                                    @if ($berkas->ktp_suami == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->ktp_suami) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->ktp_suami) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->ktp_suami) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">KTP Istri</div>
                                    @if ($berkas->ktp_istri == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->ktp_istri) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->ktp_istri) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->ktp_istri) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Buku Nikah / Akta Perkawinan</div>
                                    @if ($berkas->buku_nikah == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->buku_nikah) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->buku_nikah) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->buku_nikah) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Buku Nikah / Akta Perkawinan Orang Tua Suami</div>
                                    @if ($berkas->buku_nikah_ortu == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->buku_nikah_ortu) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->buku_nikah_ortu) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->buku_nikah_ortu) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Buku Nikah / Akta Perkawinan Orang Tua Istri</div>
                                    @if ($berkas->buku_nikah_ortu2 == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->buku_nikah_ortu2) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->buku_nikah_ortu2) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->buku_nikah_ortu2) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Surat Pindah (jika Suami atau Istri dari
                                        Desa/Kecamata/Kabupaten/Provinsi lain)</div>
                                    @if ($berkas->surat_pindah == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->surat_pindah) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->surat_pindah) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->surat_pindah) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Berkas F-1.01 Halaman 1</div>
                                    @if ($berkas->f101 == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->f101) }}" target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->f101) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->f101) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Berkas F-1.01 Halaman 2</div>
                                    @if ($berkas->f101_hal2 == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->f101_hal2) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->f101_hal2) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->f101_hal2) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Berkas F-1.01 Halaman 3</div>
                                    @if ($berkas->f101_hal3 == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->f101_hal3) }}"
                                            target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->f101_hal3) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->f101_hal3) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label">Berkas Lainnya (jika diperlukan)</div>
                                    @if ($berkas->lainnya == null)
                                        <span class="badge bg-red">Tidak ada Berkas</span>
                                    @else
                                        <a data-fslightbox="gallery"
                                            href="{{ asset('storage/uploads/kk/' . $berkas->lainnya) }}" target="_blank">
                                            <!-- Photo -->
                                            <div class="img-responsive img-responsive-3x1 rounded-3 border"
                                                style="background-image: url({{ asset('storage/uploads/kk/' . $berkas->lainnya) }})">
                                            </div>
                                        </a>
                                        <button class="btn btn-success mt-3"
                                            onclick="printFile('{{ asset('storage/uploads/kk/' . $berkas->lainnya) }}')">Cetak</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
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
