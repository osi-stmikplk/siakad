@extends('layout.report-f4-landscape')

@section('content')
<style type="text/css">
.ttd {
    width: 50px;}
@media print {
    thead{ display: table-header-group; }
}
</style>
<h2 class="text-center">Daftar Hadir Mata Kuliah</h2>
<table class="table table-condensed">
    <tr>
        <td>Mata Kuliah:</td>
        <td>{{ $dataKelas->mataKuliah->nama }}</td>
        <td>SKS:</td>
        <td>{{ $dataKelas->mataKuliah->sks }}</td>
    </tr>
    <tr>
        <td>Dosen Pengampu:</td>
        <td>{{ $dataKelas->dosen->nama }}</td>
        <td>Kelas:</td>
        <td>{{ $dataKelas->kelas }}</td>
    </tr>
    <tr>
        <td>Jurusan:</td>
        <td>{{ $dataKelas->mataKuliah->jurusan->nama }}</td>
        <td>Semester / Tahun Ajaran:</td>
        <td>{{ $dataKelas->mataKuliah->semester }} / {{ $dataKelas->tahun_ajaran }}</td>
    </tr>
</table>
<table class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th rowspan="2"><nobr>No.</nobr></th>
        <th rowspan="2">NIM</th>
        <th rowspan="2">Nama</th>
        <th colspan="16">Tanggal</th>
    </tr>
    <tr>
        @for($j=1;$j<=16;$j++)
            <td>&nbsp;</td>
        @endfor
    </tr>
    </thead>
    <tbody>
    <?php $i=0 ?>
    @foreach($mahasiswa as $m)
        <tr>
            <td><?php echo ++$i; ?></td>
            <td>{{ $m->nomor_induk }}</td>
            <td><nobr>{{ $m->nama }}</nobr></td>
            @for($j=1;$j<=16;$j++)
                <td class="ttd">&nbsp;</td>
            @endfor
        </tr>
    @endforeach
    </tbody>
</table>
@endsection