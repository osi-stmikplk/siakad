@extends($layout)

@section('content-header')
    <h1>Formulir Rencana Studi<small>sesuaikan tujuan dan kompetensi</small></h1>
@endsection

@section('content')
    <section id="frs">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <h2>Jangan Sampai Terlambat Dalam Pengisian & Pengajuan FRS</h2>
                    <p>Pengisian FRS Tahun Ajaran {{ $infoTA->tahun_ajaran }}
                    dimulai pada tanggal
                    {{ $infoTA->tgl_mulai_isi_krs }} sampai dengan {{ $infoTA->tgl_berakhir_isi_krs }}, keterlambatan
                    tidak dapat ditolerir.</p>
                </div>
                <a id="cmdMulaiIsiFRS"
                   data-ic-post-to="{{ route('mhs.frs.mulai') }}" data-ic-confirm="Yakin untuk memulai pengisian?"
                   class="btn btn-lg btn-primary">
                    <i class="fa fa-coffee"></i> Klik Untuk Memulai Pengisian!
                    @include("_ic-indicator")
                </a>
            </div>
        </div>
    </section>
@endsection

@push('late-script')
<script type="text/javascript">
$('#cmdMulaiIsiFRS')
    .on('error.ic',function(evt, elt, status, str, xhr){
        alert('UPS gagal melakukan penambahan :( ...');
    })
    .on('success.ic',function(evt, elt, data, textStatus, xhr, requestId){
            window.location.reload();
    });
</script>
@endpush
