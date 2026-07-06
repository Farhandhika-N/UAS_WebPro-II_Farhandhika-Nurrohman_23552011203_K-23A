<table border="1">

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