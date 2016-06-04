@extends('layout.report')
@section('content')
{{--
Load berdasarkan data yang dimasukkan adalah nilai IPK
--}}
<?php $nilaiAkum = ['total_sks' => 0, 'total_bobot' => 0]; ?>
<style>
table, tr, th {
	text-align: center;
	padding:3px;
	font-size: 13px;
}
.noborder {
	border: 2px solid #fff;
}
</style>

<div class="container">
<div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
	
<h2 class="text-center" style="margin-bottom:30px;">TRANSKRIP AKADEMIK SEMENTARA</h2>

<p></p>
<table class="table table-condensed" style="font-weight:bold;">
    <tr class="text-left noborder">
        <td>NIM / NAMA</td>
        <td>: {{ $mhs->nomor_induk }} / {{ $mhs->nama }}</td>
        <td></td>
    </tr>
    <tr class="text-left noborder">
        <td>Program Studi / Angkatan</td>
        <td>: {{ $mhs->jurusan->nama }} / {{ $mhs->tahun_masuk }}</td>
    </tr>
</table>

<?php $i = 0; ?>
<table class="table table-bordered table-condensed table-striped">
    <thead>
    <tr>
        <th>No.</th>
        <th>Mata Kuliah</th>
        <th>SKS</th>
        <th>Nilai</th>
        <th>SKSN</th>
        <th>Mutu</th>
        <!--th>Bobot</th-->
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>{{ ++$i }}</td>
            <td align="left">{{ $d->kode }} - {{ $d->nama }}</td>
            <td>{{ $d->sks }}</td>
            <td>{{ number_format($d->nilai_angka, 0) }}</td>
            <td><?php echo $d->nilai_angka*$d->sks; ?></td>
            <td>{{ $d->nilai_huruf }}</td>
        <?php
        $nilaiAkum['total_sks'] += $d->sks;
        $nilaiAkum['total_bobot'] += ($d->nilai_angka * $d->sks);
        ?>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2">Total SKS dan SKSN</th>
            <th>{{ number_format($nilaiAkum['total_sks'], 0, ",", ".") }}</th>
            <th>-</th>
            <th>{{ number_format($nilaiAkum['total_bobot'], 0, ",", ".") }}</th>
            <th>-</th>
        </tr>
        <tr>
            <th colspan="2">Indeks Prestasi Kumulatif</th>
            <th colspan="4">{{ number_format($nilaiAkum['total_bobot'], 0, ",", ".") }}/{{ number_format($nilaiAkum['total_sks'], 0, ",", ".") }} = {{ number_format($nilaiAkum['total_bobot'] / $nilaiAkum['total_sks'], 2, ",", ".") }}</th>
        </tr>
        <!--tr>
            <th colspan="4">Total Kredit * Bobot</th>
            <th>{{ number_format($nilaiAkum['total_bobot'], 2, ",", ".") }}</th>
        </tr>
        <tr>
            <th colspan="4">Indeks Prestasi Komulatif</th>
            <th>{{ number_format($nilaiAkum['total_bobot'] / $nilaiAkum['total_sks'], 2, ",", ".") }}</th>
        </tr-->
    </tfoot>
</table>
</div>
</div>
@endsection