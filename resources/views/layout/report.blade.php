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
</head>
<body>
<!-- Site wrapper -->
<div class="page">
    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
</div>
</body>
</html>
