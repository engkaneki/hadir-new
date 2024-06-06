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
                                <div class="subheader">Pengajuan KK</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-0 me-2">{{ $kk }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Pengajuan Akta Kelahiran</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-0 me-2">{{ $lahir }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Pengajuan Akta Kematian</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-3 me-2">{{ $kematian }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Pengajuan Surat Pindah</div>
                            </div>
                            <div class="d-flex align-items-baseline mt-3">
                                <div class="h1 mb-3 me-2">{{ $pindah }} Berkas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-deck row-cards mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart-data"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.ApexCharts && (new ApexCharts(document.getElementById('chart-data'), {
                chart: {
                    type: "area",
                    fontFamily: 'inherit',
                    height: 240,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    animations: {
                        enabled: false
                    },
                    stacked: true,
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: .16,
                    type: 'solid'
                },
                stroke: {
                    width: 2,
                    lineCap: "round",
                    curve: "smooth",
                },
                series: {!! json_encode($chartData['data']) !!}, // Membalikkan urutan warna series
                tooltip: {
                    theme: 'dark'
                },
                grid: {
                    padding: {
                        top: -20,
                        right: 0,
                        left: -4,
                        bottom: -4
                    },
                    strokeDashArray: 4,
                },
                xaxis: {
                    labels: {
                        padding: 0,
                    },
                    tooltip: {
                        enabled: false
                    },
                    axisBorder: {
                        show: false,
                    },
                    categories: {!! json_encode($chartData['labels']) !!},
                },
                yaxis: {
                    labels: {
                        padding: 4,
                        formatter: function(value) {
                            return value.toFixed(0);
                        }
                    },
                    forceNiceScale: true,
                },
                colors: [tabler.getColor("blue"), tabler.getColor("green"), tabler.getColor("red"),
                    tabler.getColor("purple")
                ],
                legend: {
                    show: true,
                    labels: {
                        colors: ['#333'],
                    },
                },
            })).render();
        });
    </script>
@endsection
