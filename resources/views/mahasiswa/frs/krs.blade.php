{{--
Cetak KHS
--}}

<html>
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
	</style>
</head>
<body>
<!-- Site wrapper -->
<div class="page container">
    <!-- Main content -->
    <div class="col-sm-offset-2 col-sm-8 col-sm-offset-2">
<h1 class="text-center">Formulir Rencana Studi</h1>
<br>
<table class="table table-condensed noborder">
    <tr>
        <td>NIM</td>
        <td>{{ $mhs->nomor_induk }}</td>
        <td>Angkatan</td>
        <td>{{ $mhs->tahun_masuk }}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>{{ $mhs->nama }}</td>
        <td>Semester</td>
        <td>{{ $mhs->dapatkanSemester($ta) }}</td>
    </tr>
    <tr>
        <td>Program Studi</td>
        <td>{{ $mhs->jurusan->nama }}</td>
        <td>Tahun Ajaran</td>
        <td>{{ $ta }}</td>
    </tr>
</table>

<?php $i = $jumlahSKS = 0; ?>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode MK</th>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Kelas</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($rincianStudi as $ris)
        <tr align="center">
            <td>{{ ++$i }}</td>
            <td>{{ $ris->kode_mk }}</td>
            <td align="left">{{ $ris->nama_mk }}</td>
            <td>{{ $ris->sks }}</td>
            <td>{{ $ris->kelas }}</td>
            <td>&nbsp;</td>
        </tr>
        <?php $jumlahSKS += $ris->sks ?>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Jumlah SKS</th>
            <th>{{ number_format($jumlahSKS) }}</th>
            <th colspan="2">&nbsp;</th>
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
    </div>
</div>
</body>
</html>

