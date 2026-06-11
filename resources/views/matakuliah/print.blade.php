<!DOCTYPE html>
<html>
<head>
    <title>Data Matakuliah</title>
</head>
<body onload="window.print()">

<h2>Data Matakuliah</h2>

<table border="1" width="100%" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>ID</th>
        <th>Nama Matakuliah</th>
        <th>SKS</th>
        <th>Jurusan</th>
    </tr>

    @foreach($matakuliahs as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->id_matakuliah }}</td>
        <td>{{ $item->nama_matakuliah }}</td>
        <td>{{ $item->sks }}</td>
        <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
    </tr>
    @endforeach
</table>

</body>
</html>