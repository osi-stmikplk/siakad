@extends('layout.report-f4-landscape')

@section('content')
<style type="text/css">
.ttd {
    width: 50px;}
.spacep {padding: 10px 0 10px 0; height: 40px;}
@media print {
    thead{ display: table-header-group; }
}
</style>
<h1 class="text-center">Daftar Hadir Mata Kuliah<br>
    Kelas {{ $dataKelas->kelas }}</h1>
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
        <td>Semester:</td>
        <td>{{ $dataKelas->mataKuliah->semester }}</td>
    </tr>
    <tr>
        <td>Jurusan:</td>
        <td>{{ $dataKelas->mataKuliah->jurusan->nama }}</td>
        <td>Tahun Ajaran:</td>
        <td>{{ $dataKelas->tahun_ajaran }}</td>
    </tr>
</table>
<table class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th rowspan="2"><nobr>No.</nobr></th>
        <th rowspan="2">NIM</th>
        <th rowspan="2">Nama</th>
        <th colspan="16" style="text-align: center">Tanggal</th>
    </tr>
    <tr>
        @for($j=1;$j<=16;$j++)
            <td>&nbsp;<br>&nbsp;</td>
        @endfor
    </tr>
    </thead>
    <tbody>
    <?php $i=0 ?>
    {{-- cetakan nama dan baris per mahasiswa --}}
    @foreach($mahasiswa as $m)
        <tr>
            <td class="spacep"><?php echo ++$i; ?></td>
            <td class="spacep">{{ $m->nomor_induk }}</td>
            <td class="spacep"><nobr>{{ $m->nama }}</nobr></td>
            @for($j=1;$j<=16;$j++)
                <td class="spacep ttd">&nbsp;</td>
            @endfor
        </tr>
    @endforeach
    <?php $max = $i + 5; ?>
    @while($i < $max)
        <tr>
            <td class="spacep">&nbsp;</td>
            <td class="spacep">&nbsp;</td>
            <td class="spacep"><nobr>&nbsp;</nobr></td>
            @for($j=1;$j<=16;$j++)
                <td class="spacep ttd">&nbsp;</td>
            @endfor
        </tr>
    @endwhile
    </tbody>
</table>

<p class="pull-right">
    Palangka Raya,<br>
    Dosen Pengampu,<br>
    <br>
    <br>
    _____________________________

</p>
@endsection