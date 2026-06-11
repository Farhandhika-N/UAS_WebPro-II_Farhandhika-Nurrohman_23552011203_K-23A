<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
</head>
<body onload="window.print()">

<h2>Data Mahasiswa</h2>

<table border="1" width="100%" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
    </tr>

    @foreach($mahasiswas as $mhs)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $mhs->nim }}</td>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->jurusan->nama_jurusan ?? '-' }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>