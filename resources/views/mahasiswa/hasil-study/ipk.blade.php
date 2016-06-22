@extends('layout.report')
@section('content')
{{--
Load berdasarkan data yang dimasukkan adalah nilai IPK
--}}
<?php $nilaiAkum = ['total_sks' => 0, 'total_bobot' => 0]; ?>

<h2 class="text-center" style="margin-bottom:30px;"><strong>TRANSKRIP AKADEMIK SEMENTARA</strong></h2>

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

<style type="text/css">
	#garis { border: 1px solid #000000; }
	th { height: 40px; font-size: 15px; }
</style>

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
        <?php
        $nilaiAkum['total_sks'] += $d->sks;
        $nilaiAkum['total_bobot'] += ($d->nilai_angka * $d->sks);
        ?>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" id="garis">Total SKS dan SKSN</th>
            <th id="garis">{{ number_format($nilaiAkum['total_sks'], 0, ",", ".") }}</th>
            <th id="garis">-</th>
            <th id="garis">{{ number_format($nilaiAkum['total_bobot'], 0, ",", ".") }}</th>
            <th id="garis">-</th>
        </tr>
        <tr>
            <th colspan="2" id="garis">Indeks Prestasi Kumulatif</th>
            <th colspan="4" id="garis">{{ number_format($nilaiAkum['total_bobot'], 0, ",", ".") }}/{{ number_format($nilaiAkum['total_sks'], 0, ",", ".") }} = {{ number_format($nilaiAkum['total_bobot'] / $nilaiAkum['total_sks'], 2, ",", ".") }}</th>
        </tr>
    </tfoot>
</table>

@endsection