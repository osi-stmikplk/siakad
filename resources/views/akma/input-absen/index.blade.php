@extends($layout)

@section('content-header')
    <h1>Pencatatan Absensi Mahasiswa<small>catat kehadiran</small></h1>
@endsection

@section('content')
    <section id="input-absensi">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <label for="ta">Tahun Ajaran:&nbsp;</label>
                            <select class="form-control" id="ta" name="ta">
                                {!! load_select('ta',
                                    \Stmik\Factories\ReferensiAkademikFactory::getTALists(
                                        ['type'=>'rangedex', 'nilai'=>[0,2]]),
                                    0, [], ['Pilih Tahun Ajaran'], true) !!}
                            </select>
                            <br>
                            <label for="jurusan">Pilih Jurusan:&nbsp;</label>
                            <select class="form-control" id="jurusan" name="jurusan"
                                data-ic-post-to="{{ route('akma.absen.loadKelas') }}"
                                data-ic-include="#ta"
                                data-ic-indicator="#kelas_indicator"
                                data-ic-target="#kelas"
                            >
                                {!! load_select('jurusan', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                                    0, [], ['Pilih Jurusan'], true) !!}
                            </select>
                            <br>
                            <label for="kelas">Pilih Kelas Mahasiswa:&nbsp;
                                <i id="kelas_indicator" class="fa fa-spin fa-spinner" style="display: none;"></i>
                            </label>
                            <select name="kelas" id="kelas" class="form-control">
                            </select>
                            <a data-ic-post-to="{{ route('akma.absen.loadDaftarMahasiswa') }}"
                                id="send-filter"
                               data-ic-target="#load-data-di-sini"
                               data-ic-include="#kelas"
                               class="form-control btn btn-sm btn-warning">
                                <i class="fa fa-exchange"></i> Render Inputan @include('_ic-indicator')
                            </a>
                        </form>
                        <p>
                            <span class="label label-info">NB:</span>
                            Pada masukan jumlah Mahasiswa nilai 0 berarti tidak ada pencatatan, nilai positif berarti
                            dihitung penjumlahan dan nilai negatif adalah mengurangi nilai, berdasarkan status keterangan terpilih.
                            Status akan otomatis memiliki nilai
                            <strong>H</strong> untuk <span class="text-green">Hadir</span>, <strong>S</strong> untuk
                            <span class="text-yellow">Sakit</span> dan <strong>TK</strong>
                            adalah <span class="text-red">Tanpa Keterangan</span> serta <strong>I</strong>
                            untuk <span class="text-bold">Ijin</span>.
                        </p>
                        <div id="load-data-di-sini"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('late-script')
<script type="text/javascript">
    var Absen = {
        renderInputan: function(e) {

        }
    };
</script>
@endpush