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
                        Berkas Belum di Antar
                    </div>
                    <h2 class="page-title">
                        Daftar Berkas Belum di Antar
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if ($user->level != 3)
                <div class="row mb-3">
                    <div class="col-12">
                        <form action="{{ url('operator/berkas/belum') }}" method="get">
                            <div class="row">
                                <div class="form-group input-icon col-4">
                                    <input type="text" name="noreg" value="{{ Request('noreg') }}"
                                        class="form-control form-control-rounded" placeholder="Cari Noreg">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                            <path d="M21 21l-6 -6"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="col-4">
                                    <input class="form-control form-control-rounded" name="petugas" list="list-desa"
                                        placeholder="Cari Desa" value="{{ Request('petugas') }}" />
                                    <datalist id="list-desa">
                                        @foreach ($petugasList as $username => $name)
                                            <option value="{{ $username }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-1">
                                    <button type="submit" class="btn btn-info">Tampilkan</button>
                                </div>
                                @if ($user->level == 1)
                                    <div class="col-1">
                                        <a href="{{ url('parrent/berkas/cetak') }}" target="_blank" class="btn btn-success">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-printer" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                <path
                                                    d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                            </svg>
                                            Cetak
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endif
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
                                    @if ($user->level == 3)
                                    @else
                                        <th>Desa</th>
                                        <th style="width: 10%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            @foreach ($berkas as $index => $item)
                                <tr>
                                    <td>{{ $berkas->firstItem() + $index }}</td>
                                    <td>{{ $item->noreg }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->jenis_berkas }}</td>
                                    @if ($user->level != 3)
                                        <td>{{ $petugasList[$item->petugas] }}</td>
                                        <td>
                                            <button class="btn btn-lime" data-bs-toggle="modal"
                                                data-bs-target="#terimaModal{{ $item->id }}">Terima</button>


                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade modal-blur modal" id="terimaModal{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="hapusModalLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="hapusModalLabel{{ $item->id }}">Konfirmasi
                                                                Terima Berkas {{ $item->jenis_berkas }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        @if ($user->level == 1)
                                                            <form action="{{ url('parrent/berkas/terima/' . $item->id) }}"
                                                                method="post">
                                                            @else
                                                                <form
                                                                    action="{{ url('operator/berkas/terima/' . $item->id) }}"
                                                                    method="post">
                                                        @endif
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="col-12 mb-3">
                                                                <div class="form-label">No. Register</div>
                                                                <input type="text" name="noreg" id=""
                                                                    class="form-control" value="{{ $item->noreg }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <div class="form-label">Atas Nama</div>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $item->nama }}" readonly>
                                                            </div>
                                                            <div class="col-12 mb-3">
                                                                <div class="form-label">Desa</div>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $petugasList[$item->petugas] }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-lime">Terima</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <br>
                    {{ $berkas->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
