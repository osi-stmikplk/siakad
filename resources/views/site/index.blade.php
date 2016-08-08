{{--
Load tampilan pertama kali / Dashboard
--}}
@extends($layout)

@section('content-header')
    <h1>STMIK Siakad<small>kepingin online</small></h1>
@endsection

@section('content')
<section id="dashboard">
    <div class="box box-info">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title">Hai {{ Session::get('nama') }}, Selamat Datang...</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="callout callout-info">
                <p>Jaga kerahasiaan akun Anda dengan sebaik-baiknya. Semua aktivitas yang terjadi atas nama akun ini menjadi tanggung jawab Anda. Jangan memberitahukan sandi Anda kepada siapapun. Segera melapor ke Bagian AKMA jika mengalami/menemui hal-hal yang mencurigakan pada aktivitas akun Anda.</p>
            </div>
        </div><!-- /.box-body -->
    </div>

    @can('dataIniHanyaBisaDipakaiOleh', 'mahasiswa')
    <div class="box box-danger">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title">Perhatian</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="callout callout-danger">
                <h3>Kepada seluruh mahasiswa, WAJIB untuk:</h3>
                <ul>
                    <li>memeriksa dan memperbaiki <a href="{{ route('mhs.dataDiri') }}">data diri</a>.</li>
                    <li>menginputkan alamat email yang aktif dan valid.</li>
                    <li>menginputkan nomor telepon/ponsel yang aktif dan dapat dihubungi.</li>
                    <li>SEGERA mengganti <a href="#" data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body" data-ic-get-from="/user/profile">sandi akun Anda</a>. Buat sandi dengan kombinasi huruf kapital dan kecil serta angka. Jangan gunakan tanggal lahir atau nomor telepon dan lainnya yang mudah ditebak.</li>
                    <li>Segera melapor ke Bagian AKMA untuk memperbaiki data yang tidak dapat diubah sendiri.</li>
                </ul>
            </div>
        </div><!-- /.box-body -->
    </div>
    @endcan
</section>
@endsection