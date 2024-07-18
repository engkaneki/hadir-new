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
                        Dokumen
                    </div>
                    <h2 class="page-title">
                        Daftar Dokumen
                    </h2>
                </div>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if ($user->level == 1)
                            <button class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#tambah">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tambah Dokumen
                            </button>
                        @endif
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
                                    <th>Nama File</th>
                                    <th>File</th>
                                    @if ($user->level == 1)
                                        <th style="width: 15%"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dokumen as $index => $item)
                                    <tr>
                                        <td>{{ $dokumen->firstItem() + $index }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ url('storage/dokumen/' . $item->file) }}"
                                                target="_blank" rel="noopener noreferrer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-download">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                                    <path d="M7 11l5 5l5 -5" />
                                                    <path d="M12 4l0 12" />
                                                </svg>
                                                Download
                                            </a>
                                        </td>
                                        <td>
                                            @if ($user->level == 1)
                                                <button class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#edit{{ $item->id }}">Edit</button>
                                                <button class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#hapus{{ $item->id }}">Hapus</button>
                                            @endif

                                            <!-- Modal Edit Operator -->
                                            <div class="modal fade modal-blur modal" id="edit{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="hapusModalLabel">Edit Operator
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ url('dokumen/edit/' . $item->id) }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="col-12 mb-3">
                                                                    <div class="form-label">Nama File</div>
                                                                    <input type="text" name="name" id=""
                                                                        class="form-control" value="{{ $item->name }}">
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <div class="form-label">File</div>
                                                                    <input type="file" name="file" id=""
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-lime">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade modal-blur modal" id="hapus{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="hapusModalLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="hapusModalLabel{{ $item->id }}">Konfirmasi
                                                                Hapus
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ url('dokumen/hapus/' . $item->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus berkas
                                                                {{ $item->name }}?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-danger">Hapus</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        {{ $dokumen->links('vendor.pagination.bootstrap-5') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Operator -->
    <div class="modal fade modal-blur modal" id="tambah" tabindex="-1" aria-labelledby="hapusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusModalLabel">Tambah Operator
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('dokumen/tambah') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12 mb-3">
                            <div class="form-label">Nama File</div>
                            <input type="text" name="name" id="" class="form-control">
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-label">File</div>
                            <input type="file" name="file" id="" class="form-control">
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
