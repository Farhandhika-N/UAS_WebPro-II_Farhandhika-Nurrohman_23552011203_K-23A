@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold text-white">
            Transkrip Nilai Mahasiswa
        </h3>

        <div>

            <a href="{{ route('transkrip.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

            <a href="{{ route('transkrip.print',$mahasiswa->id_mahasiswa) }}"
               target="_blank"
               class="btn btn-success">
                Print
            </a>

        </div>

    </div>

    <div class="card bg-dark border-secondary shadow mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-dark table-borderless mb-0">

                        <tr>
                            <th width="180">NIM</th>
                            <td>{{ $mahasiswa->nim }}</td>
                        </tr>

                        <tr>
                            <th>Nama</th>
                            <td>{{ $mahasiswa->nama }}</td>
                        </tr>

                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $mahasiswa->jurusan->nama_jurusan }}</td>
                        </tr>

                        <tr>
                            <th>Angkatan</th>
                            <td>{{ $mahasiswa->angkatan }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    @php

        $totalSks = 0;
        $totalBobot = 0;

    @endphp

    <div class="card bg-dark border-secondary shadow">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-dark table-hover">

                    <thead>

                    <tr>

                        <th>No</th>
                        <th>Kode</th>
                        <th>Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Nilai Angka</th>
                        <th>Huruf</th>
                        <th>Bobot</th>

                    </tr>

                    </thead>

                    <tbody>

                    @foreach($nilai as $n)

                        @php

                            $bobot = match($n->nilai_huruf){
                                'A' => 4,
                                'B' => 3,
                                'C' => 2,
                                'D' => 1,
                                default => 0
                            };

                            $totalSks += $n->matakuliah->sks;
                            $totalBobot += ($bobot * $n->matakuliah->sks);

                        @endphp

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $n->matakuliah->kode_matakuliah }}</td>

                            <td>{{ $n->matakuliah->nama_matakuliah }}</td>

                            <td>{{ $n->matakuliah->sks }}</td>

                            <td>{{ $n->nilai_angka }}</td>

                            <td>{{ $n->nilai_huruf }}</td>

                            <td>{{ $bobot }}</td>

                        </tr>

                    @endforeach

                    </tbody>

                    <tfoot>

                    <tr>

                        <th colspan="3">
                            Total
                        </th>

                        <th>{{ $totalSks }}</th>

                        <th colspan="2"></th>

                        <th>{{ $totalBobot }}</th>

                    </tr>

                    </tfoot>

                </table>

            </div>

            @php

                $ipk = $totalSks > 0
                    ? round($totalBobot / $totalSks,2)
                    : 0;

            @endphp

            <div class="row mt-4">

                <div class="col-md-4">

                    <div class="alert alert-primary">

                        <h5>Total SKS</h5>

                        <h3>{{ $totalSks }}</h3>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="alert alert-success">

                        <h5>Total Bobot</h5>

                        <h3>{{ $totalBobot }}</h3>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="alert alert-warning">

                        <h5>IPK</h5>

                        <h3>{{ number_format($ipk,2) }}</h3>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection