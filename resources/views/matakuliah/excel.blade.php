<table border="1">
    <tr>
        <th>Nama Matakuliah</th>
        <th>SKS</th>
        <th>Jurusan</th>
    </tr>

    @foreach($matakuliahs as $item)
    <tr>
        <td>{{ $item->nama_matakuliah }}</td>
        <td>{{ $item->sks }}</td>
        <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
    </tr>
    @endforeach
</table>