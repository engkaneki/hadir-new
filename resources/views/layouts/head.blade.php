<!doctype html>
<html lang="en">

<head>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3Z5MPM3YQS"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-3Z5MPM3YQS');
    </script>


    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>DUKCAPIL HADIR DI DESA</title>
    <!-- CSS files -->
    <link href="{{ asset('/') }}dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('/') }}assets/img/ico.png" type="image/x-icon">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand">
                    @if ($user->level == 1)
                        <a href="{{ url('parrent') }}">
                            <img src="{{ asset('/') }}assets/img/ico.png" width="110" height="32"
                                alt="Tabler" class="navbar-brand-image">
                            HADIR DI DESA
                        </a>
                    @elseif($user->level == 2)
                        <a href="{{ url('operator') }}">
                            <img src="{{ asset('/') }}assets/img/ico.png" width="110" height="32"
                                alt="Tabler" class="navbar-brand-image">
                            HADIR DI DESA
                        </a>
                    @else
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('/') }}assets/img/ico.png" width="110" height="32"
                                alt="Tabler" class="navbar-brand-image">
                            HADIR DI DESA
                        </a>
                    @endif
                </h1>
                <div class="navbar-nav flex-row d-lg-none">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            @if ($user->level == 1 || $user->level == 2 || ($user->level == 3 && optional($profil)->foto_operator))
                                @php
                                    $foto = $user->level == 3 ? $profil->foto_operator : optional($profil_op)->foto;
                                @endphp
                                <div class="col-auto">
                                    <span class="avatar avatar-sm"
                                        style="background-image: url('{{ $foto ? asset('storage/avatars/' . $foto) : asset('/') . 'static/avatars/ava.jpg' }}')"></span>
                                </div>
                            @else
                                <div class="col-auto">
                                    <span class="avatar avatar-sm"
                                        style="background-image: url('{{ asset('/') }}static/avatars/ava.jpg')"></span>
                                </div>
                            @endif

                            <div class="d-none d-xl-block ps-2">
                                <div>{{ $user->name }}</div>
                                <div class="mt-1 small text-muted">
                                    @if ($user->level == 1)
                                        Admin
                                    @elseif($user->level == 2)
                                        Petugas
                                    @else
                                        Operator Desa
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            @if ($user->level == 1)
                                <a href="{{ url('parrent/profil') }}" class="dropdown-item">Profil</a>
                            @elseif($user->level == 2)
                                <a href="{{ url('operator/profil') }}" class="dropdown-item">Profil</a>
                            @else
                                <a href="{{ url('profil') }}" class="dropdown-item">Profil</a>
                            @endif
                            <a href="{{ url('logout') }}" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                {{-- Menu Admin --}}
                @if ($user->level == 1)
                    <div class="collapse navbar-collapse" id="sidebar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item {{ request()->is('parrent') ? 'active' : '' }}">
                                <a class="nav-link show" href="{{ url('parrent') }}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Home
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['parrent/pengajuan/kk', 'parrent/pengajuan/kk/tambah', 'parrent/pengajuan/kk/detail', 'parrent/pengajuan/lahir', 'parrent/pengajuan/lahir/tambah', 'parrent/pengajuan/lahir/detail', 'parrent/pengajuan/kematian', 'parrent/pengajuan/kematian/tambah', 'parrent/pengajuan/kematian/detail', 'parrent/pengajuan/pindah', 'parrent/pengajuan/pindah/tambah', 'parrent/pengajuan/pindah/detail']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['parrent/pengajuan/kk', 'parrent/pengajuan/kk/tambah', 'parrent/pengajuan/kk/detail', 'parrent/pengajuan/lahir', 'parrent/pengajuan/lahir/tambah', 'parrent/pengajuan/lahir/detail', 'parrent/pengajuan/kematian', 'parrent/pengajuan/kematian/tambah', 'parrent/pengajuan/kematian/detail', 'parrent/pengajuan/pindah', 'parrent/pengajuan/pindah/tambah', 'parrent/pengajuan/pindah/detail']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-plus" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M10 14h4" />
                                            <path d="M12 12v4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Pengajuan
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['parrent/pengajuan/kk', 'parrent/pengajuan/kk/tambah', 'parrent/pengajuan/kk/detail', 'parrent/pengajuan/lahir', 'parrent/pengajuan/lahir/tambah', 'parrent/pengajuan/lahir/detail', 'parrent/pengajuan/kematian', 'parrent/pengajuan/kematian/tambah', 'parrent/pengajuan/kematian/detail', 'parrent/pengajuan/pindah', 'parrent/pengajuan/pindah/tambah', 'parrent/pengajuan/pindah/detail']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['parrent/pengajuan/kk', 'parrent/pengajuan/kk/tambah', 'parrent/pengajuan/kk/detail']) ? 'active' : '' }}"
                                                href="{{ url('parrent/pengajuan/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/pengajuan/lahir', 'parrent/pengajuan/lahir/tambah', 'parrent/pengajuan/lahir/detail']) ? 'active' : '' }}"
                                                href="{{ url('parrent/pengajuan/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/pengajuan/kematian', 'parrent/pengajuan/kematian/tambah', 'parrent/pengajuan/kematian/detail']) ? 'active' : '' }}"
                                                href="{{ url('parrent/pengajuan/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/pengajuan/pindah', 'parrent/pengajuan/pindah/tambah', 'parrent/pengajuan/pindah/detail']) ? 'active' : '' }}"
                                                href="{{ url('parrent/pengajuan/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['parrent/selesai/kk', 'parrent/selesai/lahir', 'parrent/selesai/kematian', 'parrent/selesai/pindah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['parrent/selesai/kk', 'parrent/selesai/lahir', 'parrent/selesai/kematian', 'parrent/selesai/pindah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-check" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 14l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Selesai
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['parrent/selesai/kk', 'parrent/selesai/lahir', 'parrent/selesai/kematian', 'parrent/selesai/pindah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['parrent/selesai/kk']) ? 'active' : '' }}"
                                                href="{{ url('parrent/selesai/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/selesai/lahir']) ? 'active' : '' }}"
                                                href="{{ url('parrent/selesai/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/selesai/kematian']) ? 'active' : '' }}"
                                                href="{{ url('parrent/selesai/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/selesai/pindah']) ? 'active' : '' }}"
                                                href="{{ url('parrent/selesai/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['parrent/ditolak/kk', 'parrent/ditolak/lahir', 'parrent/ditolak/kematian', 'parrent/ditolak/pindah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['parrent/ditolak/kk', 'parrent/ditolak/lahir', 'parrent/ditolak/kematian', 'parrent/ditolak/pindah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-off" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5.575 5.597a2 2 0 0 0 -.575 1.403v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2m0 -4v-8a2 2 0 0 0 -2 -2h-2" />
                                            <path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 1 1 0 4h-2" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Ditolak
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['parrent/ditolak/kk', 'parrent/ditolak/lahir', 'parrent/ditolak/kematian', 'parrent/ditolak/pindah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['parrent/ditolak/kk']) ? 'active' : '' }}"
                                                href="{{ url('parrent/ditolak/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/ditolak/lahir']) ? 'active' : '' }}"
                                                href="{{ url('parrent/ditolak/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/ditolak/kematian']) ? 'active' : '' }}"
                                                href="{{ url('parrent/ditolak/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/ditolak/pindah']) ? 'active' : '' }}"
                                                href="{{ url('parrent/ditolak/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['parrent/berkas/belum', 'parrent/berkas/sudah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['parrent/berkas/belum', 'parrent/berkas/sudah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-list" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 12l.01 0" />
                                            <path d="M13 12l2 0" />
                                            <path d="M9 16l.01 0" />
                                            <path d="M13 16l2 0" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Berkas
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['parrent/berkas/belum', 'parrent/berkas/sudah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['parrent/berkas/belum']) ? 'active' : '' }}"
                                                href="{{ url('parrent/berkas/belum') }}">
                                                Berkas Belum di Antar
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['parrent/berkas/sudah']) ? 'active' : '' }}"
                                                href="{{ url('parrent/berkas/sudah') }}">
                                                Berkas Sudah di Antar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item {{ request()->is('parrent/laporan') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('parrent/laporan') }}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-printer" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Laporan
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['pengguna/parrent', 'pengguna/operator', 'pengguna/desa', 'pengguna/rs']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['pengguna/parrent', 'pengguna/operator', 'pengguna/desa', 'pengguna/rs']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-users-group" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Pengguna
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['pengguna/parrent', 'pengguna/operator', 'pengguna/desa', 'pengguna/rs']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['pengguna/parrent']) ? 'active' : '' }}"
                                                href="{{ url('pengguna/parrent') }}">
                                                Akun Admin
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['pengguna/operator']) ? 'active' : '' }}"
                                                href="{{ url('pengguna/operator') }}">
                                                Akun Operator
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['pengguna/desa']) ? 'active' : '' }}"
                                                href="{{ url('pengguna/desa') }}">
                                                Akun Desa
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['pengguna/rs']) ? 'active' : '' }}"
                                                href="{{ url('pengguna/rs') }}">
                                                Akun Dokter KK
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item {{ request()->is('parrent/dokumen') ? 'active' : '' }}">
                                <a class="nav-link show" href="{{ url('parrent/dokumen') }}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-download">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M12 17v-6" />
                                            <path d="M9.5 14.5l2.5 2.5l2.5 -2.5" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dokumen
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    {{-- Menu Operator --}}
                @elseif($user->level == 2)
                    <div class="collapse navbar-collapse" id="sidebar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item {{ request()->is(['operator']) ? 'active' : '' }}">
                                <a class="nav-link {{ request()->is(['operator']) ? 'show' : '' }}"
                                    href="{{ url('operator') }}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Home
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['operator/pengajuan/kk', 'operator/pengajuan/kk/tambah', 'operator/pengajuan/kk/detail', 'operator/pengajuan/lahir', 'operator/pengajuan/lahir/tambah', 'operator/pengajuan/lahir/detail', 'operator/pengajuan/kematian', 'operator/pengajuan/kematian/tambah', 'operator/pengajuan/kematian/detail', 'operator/pengajuan/pindah', 'operator/pengajuan/pindah/tambah', 'operator/pengajuan/pindah/detail']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['operator/pengajuan/kk', 'operator/pengajuan/kk/tambah', 'operator/pengajuan/kk/detail', 'operator/pengajuan/lahir', 'operator/pengajuan/lahir/tambah', 'operator/pengajuan/lahir/detail', 'operator/pengajuan/kematian', 'operator/pengajuan/kematian/tambah', 'operator/pengajuan/kematian/detail', 'operator/pengajuan/pindah', 'operator/pengajuan/pindah/tambah', 'operator/pengajuan/pindah/detail']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-plus" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M10 14h4" />
                                            <path d="M12 12v4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Pengajuan
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['operator/pengajuan/kk', 'operator/pengajuan/kk/tambah', 'operator/pengajuan/kk/detail', 'operator/pengajuan/lahir', 'operator/pengajuan/lahir/tambah', 'operator/pengajuan/lahir/detail', 'operator/pengajuan/kematian', 'operator/pengajuan/kematian/tambah', 'operator/pengajuan/kematian/detail', 'operator/pengajuan/pindah', 'operator/pengajuan/pindah/tambah', 'operator/pengajuan/pindah/detail']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['operator/pengajuan/kk', 'operator/pengajuan/kk/tambah', 'operator/pengajuan/kk/detail']) ? 'active' : '' }}"
                                                href="{{ url('operator/pengajuan/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/pengajuan/lahir', 'operator/pengajuan/lahir/tambah', 'operator/pengajuan/lahir/detail']) ? 'active' : '' }}"
                                                href="{{ url('operator/pengajuan/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/pengajuan/kematian', 'operator/pengajuan/kematian/tambah', 'operator/pengajuan/kematian/detail']) ? 'active' : '' }}"
                                                href="{{ url('operator/pengajuan/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/pengajuan/pindah', 'operator/pengajuan/pindah/tambah', 'operator/pengajuan/pindah/detail']) ? 'active' : '' }}"
                                                href="{{ url('operator/pengajuan/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['operator/selesai/kk', 'operator/selesai/lahir', 'operator/selesai/kematian', 'operator/selesai/pindah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['operator/selesai/kk', 'operator/selesai/lahir', 'operator/selesai/kematian', 'operator/selesai/pindah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-check" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 14l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Selesai
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['operator/selesai/kk', 'operator/selesai/lahir', 'operator/selesai/kematian', 'operator/selesai/pindah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['operator/selesai/kk']) ? 'active' : '' }}"
                                                href="{{ url('operator/selesai/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/selesai/lahir']) ? 'active' : '' }}"
                                                href="{{ url('operator/selesai/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/selesai/kematian']) ? 'active' : '' }}"
                                                href="{{ url('operator/selesai/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/selesai/pindah']) ? 'active' : '' }}"
                                                href="{{ url('operator/selesai/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['operator/ditolak/kk', 'operator/ditolak/lahir', 'operator/ditolak/kematian', 'operator/ditolak/pindah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['operator/ditolak/kk', 'operator/ditolak/lahir', 'operator/ditolak/kematian', 'operator/ditolak/pindah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-off" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5.575 5.597a2 2 0 0 0 -.575 1.403v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2m0 -4v-8a2 2 0 0 0 -2 -2h-2" />
                                            <path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 1 1 0 4h-2" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Ditolak
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['operator/ditolak/kk', 'operator/ditolak/lahir', 'operator/ditolak/kematian', 'operator/ditolak/pindah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['operator/ditolak/kk']) ? 'active' : '' }}"
                                                href="{{ url('operator/ditolak/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/ditolak/lahir']) ? 'active' : '' }}"
                                                href="{{ url('operator/ditolak/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/ditolak/kematian']) ? 'active' : '' }}"
                                                href="{{ url('operator/ditolak/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/ditolak/pindah']) ? 'active' : '' }}"
                                                href="{{ url('operator/ditolak/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['operator/berkas/belum', 'operator/berkas/sudah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['operator/berkas/belum', 'operator/berkas/sudah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-list" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 12l.01 0" />
                                            <path d="M13 12l2 0" />
                                            <path d="M9 16l.01 0" />
                                            <path d="M13 16l2 0" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Berkas
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['operator/berkas/belum', 'operator/berkas/sudah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['operator/berkas/belum']) ? 'active' : '' }}"
                                                href="{{ url('operator/berkas/belum') }}">
                                                Berkas Belum di Antar
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/berkas/sudah']) ? 'active' : '' }}"
                                                href="{{ url('operator/berkas/sudah') }}">
                                                Berkas Sudah di Antar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['operator/dokter/pengajuan', 'operator/dokter/selesai', 'operator/dokter/ditolak']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['operator/dokter/pengajuan', 'operator/dokter/selesai', 'operator/dokter/ditolak']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-ambulance" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                            <path d="M6 10h4m-2 -2v4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dokter KK
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['operator/dokter/pengajuan', 'operator/dokter/selesai', 'operator/dokter/ditolak']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['operator/dokter/pengajuan']) ? 'active' : '' }}"
                                                href="{{ url('operator/dokter/pengajuan') }}">
                                                Pengajuan
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/dokter/selesai']) ? 'active' : '' }}"
                                                href="{{ url('operator/dokter/selesai') }}">
                                                Selesai
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['operator/dokter/ditolak']) ? 'active' : '' }}"
                                                href="{{ url('operator/dokter/ditolak') }}">
                                                Ditolak
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                    data-bs-auto-close="false" role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-printer" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Laporan
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item" href="./accordion.html">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item" href="./blank.html">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item" href="./blank.html">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item" href="./blank.html">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                    {{-- Menu Desa --}}
                @elseif($user->level == 3)
                    <div class="collapse navbar-collapse" id="sidebar-menu">
                        <ul class="navbar-nav pt-lg-3">
                            <li class="nav-item {{ request()->is(['/']) ? 'active' : '' }}">
                                <a class="nav-link {{ request()->is(['/']) ? 'show' : '' }}"
                                    href="{{ url('/') }}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Home
                                    </span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['pengajuan/kk', 'pengajuan/kk/tambah', 'pengajuan/kk/detail', 'pengajuan/lahir', 'pengajuan/lahir/tambah', 'pengajuan/lahir/detail', 'pengajuan/kematian', 'pengajuan/kematian/tambah', 'pengajuan/kematian/detail', 'pengajuan/pindah', 'pengajuan/pindah/tambah', 'pengajuan/pindah/detail']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['pengajuan/kk', 'pengajuan/kk/tambah', 'pengajuan/kk/detail', 'pengajuan/lahir', 'pengajuan/lahir/tambah', 'pengajuan/lahir/detail', 'pengajuan/kematian', 'pengajuan/kematian/tambah', 'pengajuan/kematian/detail', 'pengajuan/pindah', 'pengajuan/pindah/tambah', 'pengajuan/pindah/detail']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-plus" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M10 14h4" />
                                            <path d="M12 12v4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Pengajuan
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['pengajuan/kk', 'pengajuan/kk/tambah', 'pengajuan/kk/detail', 'pengajuan/lahir', 'pengajuan/lahir/tambah', 'pengajuan/lahir/detail', 'pengajuan/kematian', 'pengajuan/kematian/tambah', 'pengajuan/kematian/detail', 'pengajuan/pindah', 'pengajuan/pindah/tambah', 'pengajuan/pindah/detail']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['pengajuan/kk', 'pengajuan/kk/tambah', 'pengajuan/kk/detail']) ? 'active' : '' }}"
                                                href="{{ url('pengajuan/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['pengajuan/lahir', 'pengajuan/lahir/tambah', 'pengajuan/lahir/detail']) ? 'active' : '' }}"
                                                href="{{ url('pengajuan/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['pengajuan/kematian', 'pengajuan/kematian/tambah', 'pengajuan/kematian/detail']) ? 'active' : '' }}"
                                                href="{{ url('pengajuan/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['pengajuan/pindah', 'pengajuan/pindah/tambah', 'pengajuan/pindah/detail']) ? 'active' : '' }}"
                                                href="{{ url('pengajuan/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['selesai/kk', 'selesai/lahir', 'selesai/kematian', 'selesai/pindah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['selesai/kk', 'selesai/lahir', 'selesai/kematian', 'selesai/pindah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-check" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 14l2 2l4 -4" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Selesai
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu  {{ request()->is(['selesai/kk', 'selesai/lahir', 'selesai/kematian', 'selesai/pindah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['selesai/kk']) ? 'active' : '' }}"
                                                href="{{ url('selesai/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['selesai/lahir']) ? 'active' : '' }}"
                                                href="{{ url('selesai/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['selesai/kematian']) ? 'active' : '' }}"
                                                href="{{ url('selesai/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['selesai/pindah']) ? 'active' : '' }}"
                                                href="{{ url('selesai/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['ditolak/kk', 'ditolak/lahir', 'ditolak/kematian', 'ditolak/pindah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['ditolak/kk', 'ditolak/lahir', 'ditolak/kematian', 'ditolak/pindah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-off" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M5.575 5.597a2 2 0 0 0 -.575 1.403v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2m0 -4v-8a2 2 0 0 0 -2 -2h-2" />
                                            <path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 1 1 0 4h-2" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Ditolak
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['ditolak/kk', 'ditolak/lahir', 'ditolak/kematian', 'ditolak/pindah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['ditolak/kk']) ? 'active' : '' }}"
                                                href="{{ url('ditolak/kk') }}">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['ditolak/lahir']) ? 'active' : '' }}"
                                                href="{{ url('ditolak/lahir') }}">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['ditolak/kematian']) ? 'active' : '' }}"
                                                href="{{ url('ditolak/kematian') }}">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['ditolak/pindah']) ? 'active' : '' }}"
                                                href="{{ url('ditolak/pindah') }}">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="nav-item dropdown {{ request()->is(['berkas/belum', 'berkas/sudah']) ? 'active' : '' }}">
                                <a class="nav-link dropdown-toggle {{ request()->is(['berkas/belum', 'berkas/sudah']) ? 'show' : '' }}"
                                    href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false"
                                    role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-clipboard-list" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path
                                                d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M9 12l.01 0" />
                                            <path d="M13 12l2 0" />
                                            <path d="M9 16l.01 0" />
                                            <path d="M13 16l2 0" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Berkas
                                    </span>
                                </a>
                                <div
                                    class="dropdown-menu {{ request()->is(['berkas/belum', 'berkas/sudah']) ? 'show' : '' }}">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item {{ request()->is(['berkas/belum']) ? 'active' : '' }}"
                                                href="{{ url('berkas/belum') }}">
                                                Berkas Belum di Antar
                                            </a>
                                            <a class="dropdown-item {{ request()->is(['berkas/sudah']) ? 'active' : '' }}"
                                                href="{{ url('berkas/sudah') }}">
                                                Berkas Sudah di Antar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item {{ request()->is(['/dokumen']) ? 'active' : '' }}">
                                <a class="nav-link {{ request()->is(['/dokumen']) ? 'show' : '' }}"
                                    href="{{ url('/dokumen') }}">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-download">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                            <path
                                                d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            <path d="M12 17v-6" />
                                            <path d="M9.5 14.5l2.5 2.5l2.5 -2.5" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Dokumen
                                    </span>
                                </a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                    data-bs-auto-close="false" role="button" aria-expanded="false">
                                    <span
                                        class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-printer" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                        </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        Laporan
                                    </span>
                                </a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-column">
                                            <a class="dropdown-item" href="./accordion.html">
                                                Kartu Keluarga
                                            </a>
                                            <a class="dropdown-item" href="./blank.html">
                                                Akta Kelahiran
                                            </a>
                                            <a class="dropdown-item" href="./blank.html">
                                                Akta Kematian
                                            </a>
                                            <a class="dropdown-item" href="./blank.html">
                                                Surat Pindah
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li> --}}
                        </ul>
                    </div>
                @endif
            </div>
        </aside>
        <!-- Navbar -->
        <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            @if ($user->level == 1 || $user->level == 2 || ($user->level == 3 && optional($profil)->foto_operator))
                                @php
                                    $foto = $user->level == 3 ? $profil->foto_operator : optional($profil_op)->foto;
                                @endphp
                                <div class="col-auto">
                                    <span class="avatar avatar-sm"
                                        style="background-image: url('{{ $foto ? asset('storage/avatars/' . $foto) : asset('/') . 'static/avatars/ava.jpg' }}')"></span>
                                </div>
                            @else
                                <div class="col-auto">
                                    <span class="avatar avatar-sm"
                                        style="background-image: url('{{ asset('/') }}static/avatars/ava.jpg')"></span>
                                </div>
                            @endif

                            <div class="d-none d-xl-block ps-2">
                                <div>{{ $user->name }}</div>
                                <div class="mt-1 small text-muted">
                                    @if ($user->level == 1)
                                        Admin
                                    @elseif($user->level == 2)
                                        Petugas
                                    @else
                                        Operator Desa
                                    @endif
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            @if ($user->level == 1)
                                <a href="{{ url('parrent/profil') }}" class="dropdown-item">Profil</a>
                            @elseif($user->level == 2)
                                <a href="{{ url('operator/profil') }}" class="dropdown-item">Profil</a>
                            @else
                                <a href="{{ url('profil') }}" class="dropdown-item">Profil</a>
                            @endif
                            <a href="{{ url('logout') }}" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse" id="navbar-menu">
                </div>
            </div>
        </header>

        <div class="page-wrapper">
