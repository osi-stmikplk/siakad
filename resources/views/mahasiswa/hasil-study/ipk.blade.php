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
}
</style>

<div class="container">
	
<h2>TRANSKRIP SEMENTARA</h2>
<table class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th>Kode</th>
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
            <td>{{ $d->kode }}</td>
            <td align="left">{{ $d->nama }}</td>
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
@endsection