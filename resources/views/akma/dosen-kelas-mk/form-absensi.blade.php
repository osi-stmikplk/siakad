@extends('layout.report-f4-landscape')

@section('content')
<style type="text/css">
.ttd {
    width: 50px;}
@media print {
    thead{ display: table-header-group; }
    }
}
.table td, .table th {
    border-color: #000000 !important;
	border: 1px;
}
.table.no-border tr td, .table.no-border tr th {
  border-width: 0;
}
.table-bordered td, .table-bordered th, .table-bordered thead {
    border-color: #000000 !important;
    border: 1px solid #000000;
}
.kada-begaris tr, .kada-begaris td, .kada-begaris table {
    border: 1px solid #ffffff;
}
</style>

<?php
if($dataKelas->mataKuliah->sks >= 4)
    $kolom='24';
else
    $kolom='16'
?>

<h2 class="text-center">Daftar Hadir Mata Kuliah</h2>
<table class="table no-border table-condensed kada-begaris">
    <tr>
        <td width = 10%>Mata Kuliah</td>
        <td width = 1%> :</td>
        <td width = 30%>{{ $dataKelas->mataKuliah->nama }}</td>
        <td width = 12%>SKS</td>
        <td width = 1%> :</td>
        <td width = 15%>{{ $dataKelas->mataKuliah->sks }}</td>
    </tr>
    <tr>
        <td>Dosen Pengampu</td>
        <td> :</td>
        <td>{{ $dataKelas->dosen->nama }}</td>
        <td>Kelas</td>
        <td> :</td>
        <td>{{ $dataKelas->kelas }}</td>
    </tr>
    <tr>
        <td>Jurusan</td>
        <td> :</td>
        <td>{{ $dataKelas->mataKuliah->jurusan->nama }}</td>
        <td>Semester / Tahun Ajaran</td>
        <td> :</td>
        <td>{{ $dataKelas->mataKuliah->semester }} / {{ $dataKelas->tahun_ajaran }}</td>
    </tr>
</table>
<table class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th rowspan="3"><nobr><div align="center">No.</div></nobr></th>
        <th rowspan="3"><div align="center">NIM</div></th>
        <th rowspan="3"><div align="center">Nama</div></div></th>
        <th colspan="{{ $kolom }}"><div align="center">Pertemuan / Tanggal</div></th>
    </tr>
    <tr>
        @for($j=1;$j<=$kolom;$j++)
            <td align="center">{{ $j }}</td>
        @endfor
    </tr>
    <tr>
        @for($j=1;$j<=$kolom;$j++)
            <td>&nbsp;</td>
        @endfor
    </tr>
    </thead>
    <tbody>
    <?php $i=0 ?>
    @foreach($mahasiswa as $m)
        <tr>
            <td align="center"><?php echo ++$i; ?></td>
            <td>{{ $m->nomor_induk }}</td>
            <td><nobr>{{ $m->nama }}</nobr></td>
            @for($j=1;$j<=$kolom;$j++)
                <td class="ttd">&nbsp;</td>
            @endfor
        </tr>
    @endforeach
        @for($z=1;$z<=5;$z++)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            @for($x=1;$x<=$kolom;$x++)
                <td class="ttd">&nbsp;</td>
            @endfor
        </tr>
        @endfor
    </tbody>
</table>

<p>
    <div class="pull-right">
        Palangka Raya, ____/____/________
        <br>
        <br>
        <br>
        <br>
        <u>{{ $dataKelas->dosen->nama }}</u>
    </div>
</p>
@endsection