<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Berkas yang Belum diantar</title>
    <style>
        body {
            text-align: center;
        }

        h1 {
            margin-top: 10px;
            /* Sesuaikan sesuai kebutuhan */
        }

        table {
            margin-top: 20px;
            /* Sesuaikan sesuai kebutuhan */
            margin-left: auto;
            margin-right: auto;
            font-size: 12px;
            /* Ukuran font pada tabel */
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            /* Lebar maksimum tabel */
            overflow: auto;
            /* Menangani overflow jika tabel melewati lebar maksimum */
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        @page {
            size: F4 landscape;
            /* Mengatur ukuran halaman F4 landscape */
        }
    </style>
</head>

<body>

    <h1>Laporan Berkas yang Belum diantar</h1>

    <table border="1" cellspacing="0" cellpadding="8">
        <thead>
            <tr>
                <th style="width: 2%">No</th>
                <th>No. Register</th>
                <th>NIK Pelapor</th>
                <th>Nama Pelapor</th>
                <th>Jenis Berkas</th>
                <th>Desa</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($berkas as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->noreg }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis_berkas }}</td>
                    <td>{{ $petugasList[$item->petugas] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
