@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
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
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Berkas Sudah di Antar
                    </div>
                    <h2 class="page-title">
                        Daftar Berkas Sudah di Antar
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 2%">No</th>
                                    <th>No. Register</th>
                                    <th>NIK Pelapor</th>
                                    <th>Nama Pelapor</th>
                                    <th>Jenis Berkas</th>
                                    {{-- <th style="width: 16%">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($berkas as $index => $item)
                                    <tr>
                                        <td>{{ $berkas->firstItem() + $index }}</td>
                                        <td>{{ $item->noreg }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis_berkas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <td colspan="6">
                        {{ $berkas->links('vendor.pagination.bootstrap-5') }}
                    </td>
                </div>
            </div>
        </div>
    </div>
@endsection
