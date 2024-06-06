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
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        List Desa
                    </div>
                    <h2 class="page-title">
                        List Desa Akun {{ $operator->name }}
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#tambahDesa">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Tambah List Desa
                        </button>
                    </div>
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
                                    <th>Nama Desa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listdesa as $index => $d)
                                    <tr>
                                        <td>{{ $listdesa->firstItem() + $index }}</td>
                                        <td>{{ $d->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        {{ $listdesa->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Desa -->
    <div class="modal fade modal-blur modal" id="tambahDesa" tabindex="-1" aria-labelledby="hapusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel">Tambah Desa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('listdesa/tambah/' . $operator->username) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="col-12 mb-3">
                            <div class="form-label">Pilih Desa</div>
                            {{-- <select name="nama_desa" id="" class="form-select">
                                <option value="">Pilih Desa</option>
                                @foreach ($alldesa as $d)
                                    <option value="{{ $d->username }}">{{ $d->name }}</option>
                                @endforeach
                            </select> --}}

                            <input class="form-control form-control-rounded" name="nama_desa" list="list-desa"
                                placeholder="Cari Desa" />
                            <datalist id="list-desa">
                                @foreach ($alldesa as $d)
                                    <option value="{{ $d->username }}">
                                        {{ $d->name }}
                                    </option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-lime">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
