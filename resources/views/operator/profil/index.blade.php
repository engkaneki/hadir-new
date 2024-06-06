@extends('layouts.main')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Account Settings
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="row g-0">
                    <div class="col d-flex flex-column">
                        <form action="{{ url('operator/profil/update') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <h3 class="card-title">Foto Profil</h3>
                                <div class="row align-items-center">
                                    @if ($profil_op && $profil_op->foto)
                                        {{-- Jika ada foto, tampilkan foto dari storage --}}
                                        <div class="col-auto">
                                            <span class="avatar avatar-xl"
                                                style="background-image: url('{{ asset('storage/avatars/' . $profil_op->foto) }}')"></span>
                                        </div>
                                    @else
                                        {{-- Jika tidak ada foto, tampilkan default --}}
                                        <div class="col-auto">
                                            <span class="avatar avatar-xl"
                                                style="background-image: url('{{ asset('static/avatars/ava.jpg') }}')"></span>
                                        </div>
                                    @endif

                                    <div class="col-auto"><a href="#" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#modal-foto">
                                            Ganti Foto
                                        </a></div>
                                </div>
                                <h3 class="card-title mt-4">Informasi Profil</h3>

                                <div class="row g-3">
                                    <div class="col-md">
                                        <div class="form-label">Username</div>
                                        <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Nama Operator</div>
                                        <input name="name" type="text" class="form-control"
                                            value="{{ $user->name }}">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-md">
                                            <div class="form-label">Email</div>
                                            <input name="email" type="text" class="form-control"
                                                value="{{ $profil_op->email }}">
                                        </div>
                                        <div class="col-md">
                                            <div class="form-label">No HP</div>
                                            <input name="no_hp" type="number" name="no_hp" id=""
                                                class="form-control" value="{{ $profil_op->no_hp }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md mt-3">
                                    <div class="form-label">Password</div>
                                    <a href="#" class="btn" data-bs-toggle="modal"
                                        data-bs-target="#modal-password">
                                        Ganti Password
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Ganti Foto --}}
    <div class="modal modal-blur fade" id="modal-foto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('operator/profil/updatefoto') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Upload Foto</label>
                            <input type="file" class="form-control" name="foto">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 14l11 -11" />
                                    <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                </svg>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Password --}}
    <div class="modal modal-blur fade" id="modal-password" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('operator/profil/updatepassword') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label required">Masukkan password saat ini</label>
                            <input type="password" name="old_password" id=""
                                class="form-control @error('old_password') is-invalid @enderror">
                            @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Masukkan password baru</label>
                            <input type="password" name="new_password" id=""
                                class="form-control @error('new_password') is-invalid @enderror">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Konfirmasi password baru</label>
                            <input type="password" name="new_password_confirmation" id="" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 14l11 -11" />
                                    <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                </svg>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
