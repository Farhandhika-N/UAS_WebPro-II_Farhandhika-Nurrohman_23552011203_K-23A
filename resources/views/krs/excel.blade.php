<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Mahasiswa</th>
            <th>NIM</th>
            <th>Semester</th>
            <th>Tahun Ajaran</th>
            <th>Mata Kuliah</th>
            <th>Total SKS</th>
        </tr>
    </thead>

    <tbody>

    @foreach($krs as $item)

        @php
            $total = $item->matakuliahs->sum('sks');
        @endphp

        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $item->mahasiswa->nama }}</td>

            <td>{{ $item->mahasiswa->nim }}</td>

            <td>{{ $item->semester }}</td>

            <td>{{ $item->tahun_ajaran }}</td>

            <td>
                @foreach($item->matakuliahs as $mk)
                    {{ $mk->nama_matakuliah }}
                    @if(!$loop->last), @endif
                @endforeach
            </td>

            <td>{{ $total }}</td>

        </tr>

    @endforeach

    </tbody>

</table>