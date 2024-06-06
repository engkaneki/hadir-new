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
                        Dokter KK
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
                                    <th>Nama Ayah</th>
                                    <th>Nama Anak</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Petugas</th>
                                    @if (request()->is('operator/dokter/ditolak'))
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
                                        <td>{{ $item->nama_petugas }}</td>
                                        @if (request()->is('operator/dokter/ditolak'))
                                            <td>{{ $item->ket }}</td>
                                        @endif
                                        <td>
                                            @if ($user->level == 1)
                                                <a href="{{ url('parrent/dokter/detail/' . $item->id) }}"
                                                    class="btn btn-info">Detail</a>
                                            @else
                                                <a href="{{ url("operator/dokter/detail/{$item->id}/{$item->status}") }}"
                                                    class="btn btn-info">Detail</a>
                                            @endif

                                            @if ($item->status == 'pending')
                                                <button class="btn btn-lime" data-bs-toggle="modal"
                                                    data-bs-target="#hapusModal{{ $item->id }}">Selesai</button>
                                            @endif

                                            <!-- Modal Konfirmasi Hapus -->
                                            <div class="modal fade modal-blur modal" id="hapusModal{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="hapusModalLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="hapusModalLabel{{ $item->id }}">
                                                                Konfirmasi
                                                                Berkas Pengajaun Akta Kelahiran
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        @if ($user->level == 1)
                                                            <form action="{{ url('parrent/dokter/proses/' . $item->id) }}"
                                                                method="post">
                                                            @else
                                                                <form
                                                                    action="{{ url('operator/dokter/proses/' . $item->id) }}"
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
                                                                <select name="status" id="" class="form-select">
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
                                                            <button type="submit" class="btn btn-lime">Selesai</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $berkas->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
