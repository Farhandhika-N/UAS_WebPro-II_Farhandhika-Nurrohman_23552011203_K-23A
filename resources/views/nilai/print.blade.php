<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Nilai</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        p{
            text-align:center;
            margin-top:0;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
        }

        table th{
            background:#eeeeee;
        }

    </style>

</head>
<body>

<h2>LAPORAN DATA NILAI MAHASISWA</h2>

<p>Sistem Informasi Akademik</p>

<table>

    <thead>

        <tr>

            <th>No</th>
            <th>NIM</th>
            <th>Mahasiswa</th>
            <th>Mata Kuliah</th>
            <th>Nilai Angka</th>
            <th>Nilai Huruf</th>

        </tr>

    </thead>

    <tbody>

    @foreach($nilais as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        
        {{-- Panggil mahasiswa lewat relasi krs --}}
        <td>{{ $item->krs?->mahasiswa?->nim ?? '-' }}</td>
        <td>{{ $item->krs?->mahasiswa?->nama ?? 'Data Tidak Ditemukan' }}</td>
        
        <td>{{ $item->matakuliah?->nama_matakuliah ?? '-' }}</td>
        <td align="center">
            {{ number_format($item->nilai_angka, 2) }}
        </td>
        <td align="center">
            {{ $item->nilai_huruf }}
        </td>
    </tr>

    @endforeach

    </tbody>

</table>

<script>

window.print();

</script>

</body>
</html>