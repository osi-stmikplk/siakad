@extends($layout)

@section('content-header')
    <h1>Formulir Rencana Studi<small>sesuaikan tujuan dan kompetensi</small></h1>
@endsection

@section('content')
    <section id="frs">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h2><i class="fa fa-fire"></i> Status FRS Anda masih DRAFT. Silahkan urus status ke Akma dulu!</h2>
                    <p>Anda telah melakukan pengisian FRS, namun status FRS masih belum mendapatkan persetujuan sehingga
                        pemberitahuan ini muncul. Harap melakukan konfirmasi ke AKMA karena dapat mengakibatkan Anda
                        tidak dapat melakukan pengisian nilai dan status mahasiswa menjadi tidak AKTIF!<br>
                        Pengisian FRS Tahun Ajaran {{ $infoTA->tahun_ajaran }} dimulai pada tanggal
                        {{ $infoTA->tgl_mulai_isi_krs }} sampai dengan {{ $infoTA->tgl_berakhir_isi_krs }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
