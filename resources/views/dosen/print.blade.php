<!DOCTYPE html>
<html>

<head>

    <title>Data Dosen</title>

    <style>

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size:13px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{

            width:100%;
            border-collapse:collapse;

        }

        table th,
        table td{

            border:1px solid black;
            padding:8px;

        }

        table th{

            background:#eeeeee;

        }

    </style>

</head>

<body onload="window.print()">

<h2>

    DATA DOSEN

</h2>

<table>

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

</body>
</html>