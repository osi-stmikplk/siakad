@extends($layout)

@section('content-header')
    <h1>Formulir Rencana Studi<small>sesuaikan tujuan dan kompetensi</small></h1>
@endsection

@section('content')
    <section id="frs">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h2><i class="fa fa-fire"></i> Status FRS Telah Disetujui dan Bersifat Final</h2>
                    <p>Bila terhadap FRS yang telah disetujui terdapat perubahan, maka diharapkan menghubungi AKMA/Dosen
                        Wali untuk melakukan reset terhadap status pengisian.</p>
                    <p><a target="_blank" href="{{ route('mhs.frs.cetakKRS') }}" class="btn btn-primary"><i class="fa fa-print"></i> Klik Untuk Mencetak KRS</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection
