{{--
Cetak KHS
--}}

@extends('layout.report')
@section('content')
{{--
Load berdasarkan data yang dimasukkan adalah nilai IPK
--}}
	
<style type="text/css">
	#garis { border: 1px solid #000000; }
	th { height: 40px; font-size: 15px; }
</style>

<h2 class="text-center"><strong>*** Formulir Rencana Studi ***</strong></h2>
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
        <td>: {{ $mhs->dapatkanSemester($ta) }}</td>
    </tr>
    <tr class="text-left noborder">
        <td>Program Studi</td>
        <td>: {{ $mhs->jurusan->nama }}</td>
        <td>Tahun Ajaran</td>
        <td>: {{ $ta }}</td>
    </tr>
</table>

<?php $i = $jumlahSKS = 0; ?>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr id="garis">
            <th id="garis">No.</th>
            <th id="garis">Mata Kuliah</th>
            <th id="garis">SKS</th>
            <th id="garis">Kelas</th>
            <th id="garis">Catatan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rincianStudi as $ris)
        <tr align="center">
            <td id="garis">{{ ++$i }}</td>
            <td align="left" id="garis">{{ $ris->kode_mk }} - {{ $ris->nama_mk }}</td>
            <td id="garis">{{ $ris->sks }}</td>
            <td id="garis">{{ $ris->kelas }}</td>
            <td id="garis">&nbsp;</td>
        </tr>
        <?php $jumlahSKS += $ris->sks ?>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" id="garis">Jumlah SKS</th>
            <th id="garis">{{ number_format($jumlahSKS) }}</th>
            <th colspan="2" id="garis">&nbsp;</th>
        </tr>
    </tfoot>
</table>
<p class="pull-right">
    Palangka Raya,<br>
    Pembimbing Akademik,<br>
<br>
<br>
    _____________________________
	<br><br>

	Tanggal Cetak {{ date('d-m-Y H:i') }}
</p>

@endsection