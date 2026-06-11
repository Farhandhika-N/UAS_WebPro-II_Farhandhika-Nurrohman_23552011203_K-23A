<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($mahasiswas as $item)
        <tr>
            <td>{{ $item->id_mahasiswa }}</td>
            <td>{{ $item->nim }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>