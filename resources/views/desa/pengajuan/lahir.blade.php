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
                    @if (request()->is('selesai/lahir'))
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Pengajuan Berkas Selesai
                        </div>
                    @elseif (request()->is('ditolak/lahir'))
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
                        Akta Kelahiran
                    </h2>
                </div>

                @if (request()->is('pengajuan/lahir'))
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ url('pengajuan/lahir/tambah') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Buat Pengajuan Akta Kelahiran
                            </a>
                        </div>
                    </div>
                @else
                @endif
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if ($user->level == 2 && request()->is('operator/pengajuan/lahir'))
                <div class="row mb-3">
                    <div class="col-12">
                        <form action="{{ url('operator/pengajuan/lahir') }}" method="get">
                            <div class="row">
                                <div class="form-group input-icon col-4">
                                    <input type="text" name="nama" value="{{ Request('nama') }}"
                                        class="form-control form-control-rounded" placeholder="Cari Nama Anak">
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
                                <div class="col-2">
                                    <button type="submit" class="btn btn-info">Tampilkan</button>
                                </div>
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
                                    <th>Nama Ayah</th>
                                    <th>Nama Anak</th>
                                    <th>Tanggal Pengajuan</th>
                                    @if ($user->level == 3)
                                    @else
                                        <th>Petugas</th>
                                    @endif
                                    @if (request()->is(['ditolak/lahir', 'operator/ditolak/lahir', 'parrent/ditolak/lahir']))
                                        <th>Keterangan</th>
                                    @endif
                                    <th style="width: 16%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($berkas as $index => $item)
                                    <tr>
                                        <td>{{ $berkas->firstItem() + $index }}</td>
                                        <td>{{ $item->noreg }}</td>
                                        <td>{{ $item->nama_ayah }}</td>
                                        <td>{{ $item->nama_anak }}</td>
                                        <td>{{ $item->tgl_pengajuan }}</td>
                                        @if ($user->level == 3)
                                        @else
                                            <td>{{ $item->nama_petugas }}</td>
                                        @endif
                                        @if ($item->status == 'ditolak')
                                            <td>{{ $item->ket }}</td>
                                        @endif
                                        <td>
                                            @if ($user->level == 3)
                                                @if (request()->is('selesai/lahir'))
                                                    <a href="{{ url('selesai/lahir/detail/' . $item->id) }}"
                                                        class="btn btn-info">Detail</a>
                                                @elseif (request()->is('ditolak/lahir'))
                                                    <a href="{{ url('ditolak/lahir/detail/' . $item->id) }}"
                                                        class="btn btn-info">Detail</a>
                                                @else
                                                    <a href="{{ url('pengajuan/lahir/detail/' . $item->id) }}"
                                                        class="btn btn-info">Detail</a>
                                                    <button class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal{{ $item->id }}">Hapus</button>
                                                @endif
                                            @else
                                                @if ($item->status == 'selesai')
                                                    @if ($user->level == 1)
                                                        <a href="{{ url('parrent/selesai/lahir/detail/' . $item->id) }}"
                                                            class="btn btn-info">Detail</a>
                                                    @else
                                                        <a href="{{ url('operator/selesai/lahir/detail/' . $item->id) }}"
                                                            class="btn btn-info">Detail</a>
                                                    @endif
                                                @elseif ($item->status == 'ditolak')
                                                    @if ($user->level == 1)
                                                        <a href="{{ url('parrent/ditolak/lahir/detail/' . $item->id) }}"
                                                            class="btn btn-info">Detail</a>
                                                    @else
                                                        <a href="{{ url('operator/ditolak/lahir/detail/' . $item->id) }}"
                                                            class="btn btn-info">Detail</a>
                                                    @endif
                                                @else
                                                    @if ($user->level == 1)
                                                        <a href="{{ url('parrent/pengajuan/lahir/detail/' . $item->id) }}"
                                                            class="btn btn-info">Detail</a>
                                                    @else
                                                        <a href="{{ url('operator/pengajuan/lahir/detail/' . $item->id) }}"
                                                            class="btn btn-info">Detail</a>
                                                    @endif
                                                    <button class="btn btn-lime" data-bs-toggle="modal"
                                                        data-bs-target="#hapusModal{{ $item->id }}">Selesai</button>
                                                @endif
                                            @endif

                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade modal-blur modal" id="hapusModal{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="hapusModalLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        @if ($user->level == 3)
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="hapusModalLabel{{ $item->id }}">Konfirmasi
                                                                    Hapus
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ url('pengajuan/lahir/hapus/' . $item->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin menghapus data pengajuan Akta
                                                                    Kelahiran atas
                                                                    nama {{ $item->nama_anak }}?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="hapusModalLabel{{ $item->id }}">Konfirmasi
                                                                    Berkas Pengajaun Akta Kelahiran
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            @if ($user->level == 1)
                                                                <form
                                                                    action="{{ url('parrent/pengajuan/lahir/selesai/' . $item->id) }}"
                                                                    method="post">
                                                                @else
                                                                    <form
                                                                        action="{{ url('operator/pengajuan/lahir/selesai/' . $item->id) }}"
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
                                                                    <div class="form-label">Status</div>
                                                                    <select name="status" id=""
                                                                        class="form-select">
                                                                        <option value="selesai">Selesai</option>
                                                                        <option value="ditolak">Ditolak</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <div class="form-label">Keterangan</div>
                                                                    <textarea name="ket" id="" cols="30" rows="5" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-lime">Selesai</button>
                                                            </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <br>
                    {{ $berkas->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
