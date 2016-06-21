<!DOCTYPE html>
{{--
Ini adalah layout utama yang digunakan untuk reporting dokumen resmi.
Di sini ditambahkan header, misalkan untuk header kampus! Karena untuk reporting tidak ada yang menambahkan script
tertentu, css bisa saja ditambahkan. Agar bisa menggunakan library PDF dengan keterbatasan pada penggunaan CSS maka agar
diperhatikan untuk menggunakan CSS yang sudah compatible saja, kalau tidak bisa dicarikan alternative lain?
TODO: tambahkan css untuk reporting, sementara hanya css kosong
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
table, tr, th {
	text-align: center;
	padding:3px;
	font-size: 13px;
}
.noborder {
	border: 2px solid #fff;
}
h2, h4 { margin: 0px auto; }
</style>

	
</head>
<body>
<!-- Site wrapper -->
<div class="page">
    <!-- Main content -->
    <section class="content">
<div class="container" style="width:19cm;margin-top:33px;">
<!--div class="col-sm-offset-2 col-sm-8 col-sm-offset-2"-->

<table border="0" width="100%">	
	<tr>
		<td rowspan="3">
			<img src="/plugins/logo_stmikplk.jpg" width="100px">
		</td>
		<td><h4>SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER</h4></td>
	</tr>
	<tr>
		<td><h2>STMIK PALANGKA RAYA</h2></td>
	</tr>
	<tr>
		<td>
			Jl. G. Obos No. 114 Palangkaraya ~ <span class="glyphicon glyphicon-phone-alt"></span> 0536-3225515 ~ <span class="glyphicon glyphicon-print"></span> 0536-3236933
			<br>
			<span class="glyphicon glyphicon-globe"></span> www.stmikplk.ac.id ~ <span class="glyphicon glyphicon-envelope"></span> humas@stmikplk.ac.id
		</td>
	</tr>
</table>
<hr style="border:1px solid #777">
        @yield('content')
</div>
    </section>
</div>
</body>
</html>
