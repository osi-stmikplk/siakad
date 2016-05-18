@extends($layout)

@section('content-header')
    <h1>Formulir Rencana Studi<small>sesuaikan tujuan dan kompetensi</small></h1>
@endsection

@section('content')
    <section id="frs">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h2><i class="fa fa-fire"></i> Belum waktunya pengisian FRS atau waktu pengisian telah lewat?!</h2>
                    <p>Pengisian FRS Tahun Ajaran {{ $infoTA->tahun_ajaran }} dimulai pada tanggal
                        {{ $infoTA->tgl_mulai_isi_krs }} sampai dengan {{ $infoTA->tgl_berakhir_isi_krs }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
