@extends('layouts.main')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Dashboard
                    </div>
                    <h2 class="page-title">
                        Selamat Datang {{ $user->name }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Jumlah Desa/Kelurahan Bergabung</div>
                            </div>
                            <div class="h1 mb-3">{{ $jumlahDesa }}</div>
                            <div class="d-flex mb-2">
                                <div>Persentase Desa Bergabung</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{ number_format($persentaseDesa, 2) }}%
                                    </span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $persentaseDesa }}%;"
                                    aria-valuenow="{{ $persentaseDesa }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Total Seluruh Pengajuan</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-0 me-2">{{ $totalPengajuan }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Total Pengajuan Bulan Ini</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-3 me-2">{{ $totalPengajuanBulanIni }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Berkas Belum Di Antar</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-3 me-2">{{ $totalBerkas }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
