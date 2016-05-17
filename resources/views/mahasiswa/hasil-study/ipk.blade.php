@extends('layout.report')
@section('content')
{{--
Load berdasarkan data yang dimasukkan adalah nilai IPK
--}}
<?php $nilaiAkum = ['total_sks' => 0, 'total_bobot' => 0]; ?>
<table class="table">
    <thead>
    <tr>
        <th>Kode MK</th>
        <th>Nama MK</th>
        <th>SKS</th>
        <th>Nilai</th>
        <th>Bobot</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td>{{ $d->kode }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->sks }}</td>
            <td>{{ $d->nilai_huruf }}</td>
            <td>{{ $d->nilai_angka }}</td>
        </tr>
        <?php
        $nilaiAkum['total_sks'] += $d->sks;
        $nilaiAkum['total_bobot'] += ($d->nilai_angka * $d->sks);
        ?>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Total SKS</th>
            <th>{{ number_format($nilaiAkum['total_sks'], 2, ",", ".") }}</th>

        </tr>
        <tr>
            <th colspan="4">Total Bobot * SKS</th>
            <th>{{ number_format($nilaiAkum['total_bobot'], 2, ",", ".") }}</th>
        </tr>
        <tr>
            <th colspan="4">Indeks Prestasi Komulatif</th>
            <th>{{ number_format($nilaiAkum['total_bobot'] / $nilaiAkum['total_sks'], 2, ",", ".") }}</th>
        </tr>
    </tfoot>
</table>
@endsection