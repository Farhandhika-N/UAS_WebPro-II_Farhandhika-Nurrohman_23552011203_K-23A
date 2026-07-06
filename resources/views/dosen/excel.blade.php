<table border="1">

    <thead>

    <tr>

        <th>No</th>
        <th>NIDN</th>
        <th>Nama Dosen</th>
        <th>Email</th>
        <th>No HP</th>
        <th>Alamat</th>

    </tr>

    </thead>

    <tbody>

    @foreach($dosens as $dosen)

    <tr>

        <td>{{ $loop->iteration }}</td>

        <td>{{ $dosen->nidn }}</td>

        <td>{{ $dosen->nama_dosen }}</td>

        <td>{{ $dosen->email }}</td>

        <td>{{ $dosen->no_hp }}</td>

        <td>{{ $dosen->alamat }}</td>

    </tr>

    @endforeach

    </tbody>

</table>