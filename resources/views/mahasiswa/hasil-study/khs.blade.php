{{--
Cetak KHS
--}}

@extends('layout.report')
@section('content')
{{--
???
--}}

<style type="text/css">
	#garis { border: 1px solid #000000; }
	th { height: 40px; font-size: 15px; }
</style>

<h2 class="text-center"><strong>*** Kartu Hasil Studi ***</strong></h2>
<br>
<table class="table table-condensed">
    <tr class="text-left noborder">
        <td>NIM</td>
        <td>: {{ $mhs->nomor_induk }}</td>
        <td>Angkatan</td>
        <td>: {{ $mhs->tahun_masuk }}</td>
    </tr>
    <tr class="text-left noborder">
        <td>Nama</td>
        <td>: {{ $mhs->nama }}</td>
        <td>Semester</td>
        <td>: {{ $semester }}</td>
    </tr>
    <tr class="text-left noborder">
        <td>Program Studi</td>
        <td>: {{ $mhs->jurusan->nama }}</td>
        <td>Tahun Ajaran</td>
        <td>: {{ $ta }}</td>
    </tr>
</table>

<?php $nilaiAkum = ['total_sks' => 0, 'total_bobot' => 0]; ?>

<?php $i = 0; ?>
<table class="table table-bordered table-condensed table-striped">
    <thead>
    <tr>
        <th id="garis">No.</th>
        <th id="garis">Mata Kuliah</th>
        <th id="garis">SKS</th>
        <th id="garis">Nilai</th>
        <th id="garis">SKSN</th>
        <th id="garis">Mutu</th>
        <th id="garis">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            <td id="garis">{{ ++$i }}</td>
            <td align="left" id="garis">{{ $d->kode }} - {{ $d->nama }}</td>
            <td id="garis">{{ $d->sks }}</td>
            <td id="garis">{{ number_format($d->nilai_angka, 0) }}</td>
            <td id="garis"><?php echo $d->nilai_angka*$d->sks; ?></td>
            <td id="garis">{{ $d->nilai_huruf }}</td>
            <td id="garis">{{ $d->status_lulus }}</td>
        <?php
        $nilaiAkum['total_sks'] += $d->sks;
        $nilaiAkum['total_bobot'] += ($d->nilai_angka * $d->sks);
        ?>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" id="garis">Jumlah SKS, SKSN dan IPS</th>
            <th id="garis">{{ number_format($nilaiAkum['total_sks'], 0, ",", ".") }}</th>
            <th id="garis">-</th>
            <th id="garis">{{ number_format($nilaiAkum['total_bobot'], 0, ",", ".") }}</th>
            <th id="garis" colspan="2">{{ number_format($nilaiAkum['total_bobot'], 0, ",", ".") }}/{{ number_format($nilaiAkum['total_sks'], 0, ",", ".") }} = {{ number_format($nilaiAkum['total_bobot'] / $nilaiAkum['total_sks'], 2, ",", ".") }}</th>
        </tr>
    </tfoot>
</table>

<p class="pull-right">
    Palangka Raya,<br>
    Kabag Akma,<br>
<br>
<br>
    _____________________________
	<br><br>

	Tanggal Cetak {{ date('d-m-Y H:i') }}<br>
	<span class="text-danger">KHS ini tidak sah tanpa tandatangan dan stempel!</span>
</p>
@endsection