<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data KRS Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-transform: uppercase; font-size: 11px; }
        .text-center { text-align: center; }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h3>Daftar Kartu Rencana Studi (KRS)</h3>
        <p>Laporan Data Akademik Mahasiswa</p>
    </div>

<table>
        <thead>
            <tr>
                <th width="30" class="text-center">No</th>
                <th>Mahasiswa</th>
                <th>NIM</th>
                <th>Jurusan</th>
                <th class="text-center">Semester</th>
                <th>Tahun Ajaran</th>
                <th>Matakuliah Terpilih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($krs as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->mahasiswa->nama ?? '-' }}</td>
                <td>{{ $item->mahasiswa->nim ?? '-' }}</td>
                <td>{{ $item->mahasiswa->jurusan->nama_jurusan ?? '-' }}</td>
                <td class="text-center">Semester {{ $item->semester }}</td>
                <td>{{ $item->tahun_ajaran }}</td>
                <td>
                    @forelse($item->nilais as $nilai)
                        @if($nilai->matakuliah)
                            <span class="badge bg-info text-dark mb-1 d-inline-block">
                                {{ $nilai->matakuliah->nama_matakuliah }} ({{ $nilai->matakuliah->sks }} SKS)
                            </span>
                        @endif
                    @empty
                        <span class="text-muted small">Belum ambil MK</span>
                    @endforelse
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>