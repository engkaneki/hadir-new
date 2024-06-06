@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Laporan
                    </div>
                    <h2 class="page-title">
                        Dashboard
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h1>Jumlah Berkas Harian</h1>
                        </div>
                        <div class="card-body">
                            <div id="data-harian"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h1>Jumlah Berkas Bulan {{ $bulan }} {{ $tahun }}</h1>
                        </div>
                        <div class="card-body">
                            <div id="data-bulanan"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Desa</th>
                                    <th>PengajuanKK</th>
                                    <th>PengajuanAktaLahir</th>
                                    <th>PengajuanKematian</th>
                                    <th>PengajuanSuratPindah</th>
                                    <th>Total Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php
                                    // Inisialisasi variabel pagination
                                    $perPage = 10; // Jumlah item per halaman
                                    $currentPage = request()->get('page', 1);
                                    $startIndex = ($currentPage - 1) * $perPage;
                                    $slicedDesa = array_slice($desa, $startIndex, $perPage, true);
                                @endphp --}}

                                @foreach ($desa as $index => $desaUser)
                                    <tr>
                                        <td>{{ $desa->firstItem() + $index }}</td>
                                        <td>{{ $desaUser->name }}</td>
                                        <td>{{ $desaUser->pengajuanKKCount ?? 'Data not available' }}</td>
                                        <td>{{ $desaUser->pengajuanAktaLahirCount ?? 'Data not available' }}</td>
                                        <td>{{ $desaUser->pengajuanKematianCount ?? 'Data not available' }}</td>
                                        <td>{{ $desaUser->pengajuanSuratPindahCount ?? 'Data not available' }}</td>
                                        <td>{{ $desaUser->totalPengajuan ?? 'Data not available' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $desa->links('vendor.pagination.bootstrap-5') }}
                    </div>
                    <br>
                    <!-- Tampilkan manual pagination links -->
                    {{-- @if (count($desa) > $perPage)
                        <div class="pagination">
                            @for ($i = 1; $i <= ceil(count($desa) / $perPage); $i++)
                                <a href="?page={{ $i }}"
                                    @if ($i == $currentPage) class="active" @endif>{{ $i }}</a>
                            @endfor
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Jumlah Berkas Harian --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengambil data dari controller dan merender chart
            fetch('/parrent/chart-harian')
                .then(response => response.json())
                .then(data => renderChart(data))
                .catch(error => console.error('Error fetching data:', error));

            // Fungsi untuk merender chart dengan data yang diterima
            function renderChart(data) {
                window.ApexCharts && (new ApexCharts(document.getElementById('data-harian'), {
                    chart: {
                        type: "donut",
                        fontFamily: 'inherit',
                        height: 240,
                        sparkline: {
                            enabled: true
                        },
                        animations: {
                            enabled: false
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    series: [data.jumlahKK, data.jumlahAktaKelahiran, data.jumlahKematian, data
                        .jumlahSuratPindah
                    ],
                    labels: ["Kartu Keluarga", "Akta Kelahiran", "Akta Kematian", "Surat Pindah"],
                    tooltip: {
                        theme: 'dark'
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    colors: ['#3e82f7', '#FFBD33', '#FF5733', '#ced4da'],
                    legend: {
                        show: true,
                        position: 'bottom',
                        offsetY: 12,
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 100,
                        },
                        itemMargin: {
                            horizontal: 8,
                            vertical: 8
                        },
                    },
                    tooltip: {
                        fillSeriesColor: false
                    },
                })).render();
            }
        });
    </script>

    {{-- Jumlah Berkas Bulanan --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengambil data dari controller dan merender chart
            fetch('/parrent/chart-bulanan')
                .then(response => response.json())
                .then(data => renderChart(data))
                .catch(error => console.error('Error fetching data:', error));

            // Fungsi untuk merender chart dengan data yang diterima
            function renderChart(data) {
                window.ApexCharts && (new ApexCharts(document.getElementById('data-bulanan'), {
                    chart: {
                        type: "donut",
                        fontFamily: 'inherit',
                        height: 240,
                        sparkline: {
                            enabled: true
                        },
                        animations: {
                            enabled: false
                        },
                    },
                    fill: {
                        opacity: 1,
                    },
                    series: [data.jumlahKK, data.jumlahAktaKelahiran, data.jumlahKematian, data
                        .jumlahSuratPindah
                    ],
                    labels: ["Kartu Keluarga", "Akta Kelahiran", "Akta Kematian", "Surat Pindah"],
                    tooltip: {
                        theme: 'dark'
                    },
                    grid: {
                        strokeDashArray: 4,
                    },
                    colors: ['#3e82f7', '#FFBD33', '#FF5733', '#ced4da'],
                    legend: {
                        show: true,
                        position: 'bottom',
                        offsetY: 12,
                        markers: {
                            width: 10,
                            height: 10,
                            radius: 100,
                        },
                        itemMargin: {
                            horizontal: 8,
                            vertical: 8
                        },
                    },
                    tooltip: {
                        fillSeriesColor: false
                    },
                })).render();
            }
        });
    </script>
@endsection
