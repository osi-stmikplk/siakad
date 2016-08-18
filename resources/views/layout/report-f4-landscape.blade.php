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
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <title>{{ config('kejar.title') }}</title>
    <link rel="stylesheet" href="{{ asset('reportingstyle.css') }}">
	<link href="/plugins/bootstrap/bootstrap.min.css" rel="stylesheet">
	<script src="/plugins/bootstrap/jQuery-2.2.0.min.js"></script>
	<script src="/plugins/bootstrap/bootstrap.min.js"></script>
	
<style type="text/css">
body { color: #000000; }
table, tr, th {
	text-align: left;
	padding:3px;
	font-size: 13px;
}
.noborder {
	border: 2px solid #fff;
}
h2, h4 { margin: 0px auto; }
a.click-close {
	color: #000;
	text-decoration: none;
}

{{-- ubah ke landscape --}}
@page {
	size: 33.02cm 21.59cm;
	margin:0.97cm 0.84cm 1.50cm 0cm;
}
</style>

	
</head>
<body>
<!-- Site wrapper -->
<a onclick="javascript:window.close();" class="click-close">
<div class="page">
    <!-- Main content -->
    <section class="content">
		<div class="container" style="width:30cm; margin-top:17px;">

			<table border="0" width="100%">	
				<tr>
					<td rowspan="3">
						<img src="/plugins/logo_stmikplk.jpg" width="80px">
					</td>
					<td><h4>SEKOLAH TINGGI MANAJEMEN INFORMATIKA DAN KOMPUTER</h4></td>
				</tr>
				<tr>
					<td><h2 class="text-primary" style="letter-spacing: 4px;"><strong>STMIK PALANGKA RAYA</strong></h2></td>
				</tr>
				<tr>
					<td>
						<span class="text-danger">
							Jalan George Obos No. 114 Palangka Raya ~ <span class="glyphicon glyphicon-phone-alt"></span> 0536-3225515 ~ <span class="glyphicon glyphicon-print"></span> 0536-3236933
						</span>
						<br>
						<span class="text-success">
							<span class="glyphicon glyphicon-globe"></span> www.stmikplk.ac.id ~ <span class="glyphicon glyphicon-envelope"></span> humas@stmikplk.ac.id
						</span>
					</td>
				</tr>
			</table>
			<hr style="border:2px solid #000000; margin-top: 5px;">
			@yield('content')
		</div>
    </section>
</div>
</a>
</body>
</html>
