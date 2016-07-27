@extends($layout)
@section('content-header')
    <h1>Data Diri Mahasiswa<small>update data yang kekinian</small></h1>
@endsection
@section('content')
<section id="data-diri">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <p class="alert alert-info">
                        <i class="fa fa-info-circle"></i> Segera hubungi AKMA untuk data yang tidak bisa Anda edit namun keliru dimasukkan.</p>
                    @include('mahasiswa.data-diri.form')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection