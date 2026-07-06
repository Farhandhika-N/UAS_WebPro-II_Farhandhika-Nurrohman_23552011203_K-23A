<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Transkrip Nilai</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    margin:40px;
    color:#000;
}

h2{
    text-align:center;
    margin-bottom:5px;
}

h4{
    text-align:center;
    margin-top:0;
    margin-bottom:30px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table,th,td{
    border:1px solid #000;
}

th,td{
    padding:8px;
    font-size:13px;
}

.info{
    width:100%;
    margin-bottom:20px;
}

.info td{
    border:none;
    padding:4px;
}

.summary{
    width:40%;
    margin-left:auto;
    margin-top:20px;
}

.summary td{
    border:none;
    padding:6px;
}

.signature{
    width:250px;
    float:right;
    margin-top:60px;
    text-align:center;
}

</style>

</head>

    <body>

    <h2>TRANSKRIP NILAI</h2>
    <h4>SISTEM INFORMASI AKADEMIK</h4>

    <table class="info">

    <tr>
        <td width="150">NIM</td>
        <td>: {{ $mahasiswa->nim }}</td>
    </tr>

    <tr>
        <td>Nama</td>
        <td>: {{ $mahasiswa->nama }}</td>
    </tr>

    <tr>
        <td>Jurusan</td>
        <td>: {{ $mahasiswa->jurusan->nama_jurusan }}</td>
    </tr>

    <tr>
        <td>Angkatan</td>
        <td>: {{ $mahasiswa->angkatan }}</td>
    </tr>

    </table>

@php

$totalSks=0;
$totalBobot=0;

@endphp

<table>

<thead>

    <tr>

        <th>No</th>
        <th>Kode MK</th>
        <th>Mata Kuliah</th>
        <th>SKS</th>
        <th>Nilai</th>
        <th>Huruf</th>
        <th>Bobot</th>

    </tr>

</thead>

<tbody>

@foreach($nilais as $n)

@php

$bobot = match($n->nilai_huruf){
'A'=>4,
'B'=>3,
'C'=>2,
'D'=>0,
default=>0
};

$totalSks += $n->matakuliah->sks;
$totalBobot += ($bobot * $n->matakuliah->sks);

@endphp

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ $n->matakuliah->kode_matakuliah }}</td>

    <td>{{ $n->matakuliah->nama_matakuliah }}</td>

    <td align="center">{{ $n->matakuliah->sks }}</td>

    <td align="center">{{ $n->nilai_angka }}</td>

    <td align="center">{{ $n->nilai_huruf }}</td>

    <td align="center">{{ $bobot }}</td>

</tr>

@endforeach

</tbody>

</table>

    @php

    $ipk = $totalSks > 0 ? round($totalBobot/$totalSks,2) : 0;

    @endphp

<table class="summary">

<tr>
    <td>Total SKS</td>
    <td>: {{ $totalSks }}</td>
    </tr>

    <tr>
    <td>Total Bobot</td>
    <td>: {{ $totalBobot }}</td>
    </tr>

    <tr>
    <td>IPK</td>
    <td>: {{ number_format($ipk,2) }}</td>
</tr>

</table>

<div class="signature">

    <p>Bandung, {{ now()->translatedFormat('d F Y') }}</p>

    <br><br><br>

    <p><b>(_____________________)</b></p>

    <p>Ketua Program Studi</p>

</div>

<script>
    window.print();
</script>

</body>
</html>