{{--
Cetak KHS
--}}

<!--html>
<head>
    <meta charset="utf-8">
    <title>{{ config('kejar.title') }}</title>
    <link rel="stylesheet" href="{{ asset('reportingstyle.css') }}">
	<link href="/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
	<script src="/plugins/bootstrap/jQuery-2.2.0.min.js"></script>
	<script src="/plugins/bootstrap/bootstrap.min.js"></script>
	
	<style>
	table { font-size:13px; }
	th { text-align: center; }
	tr, td { border: solid 0px #fff; }
	.noborder {
		border: 2px solid #fff;
	}
	</style>
</head>
<body>
<!-- Site wrapper -->
<!--div class="container">
    <!-- Main content -->
    <!--div class="col-sm-offset-2 col-sm-8 col-sm-offset-2"-->
@extends('layout.report')
@section('content')
{{--
Load berdasarkan data yang dimasukkan adalah nilai IPK
--}}
	
<style type="text/css">
	#garis { border: 1px solid #000000; }
	th { height: 40px; font-size: 15px; }
</style>

<h2 class="text-center">Formulir Rencana Studi</h2>
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
            <th id="garis">No</th>
            <th id="garis">Kode MK</th>
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
            <td id="garis">{{ $ris->kode_mk }}</td>
            <td align="left" id="garis">{{ $ris->nama_mk }}</td>
            <td id="garis">{{ $ris->sks }}</td>
            <td id="garis">{{ $ris->kelas }}</td>
            <td id="garis">&nbsp;</td>
        </tr>
        <?php $jumlahSKS += $ris->sks ?>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" id="garis">Jumlah SKS</th>
            <th id="garis">{{ number_format($jumlahSKS) }}</th>
            <th colspan="2" id="garis">&nbsp;</th>
        </tr>
    </tfoot>
</table>
<p class="pull-right">
    Palangka Raya,<br>
    Pembimbing Akademik<br>
<br>
<br>
    ______________________________
	<br><br>

	Tanggal Cetak {{ date('d-m-Y H:i') }}
</p>
    <!--/div>
</div>
</body>
</html-->

@endsection