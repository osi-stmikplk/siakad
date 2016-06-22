@extends($layout)
@section('content-header')
    <h1>Persetujuan Pengajuan KRS Tahun Ajaran {{ $TAAktif }}
        <small>Kartu Rencana Studi Mahasiswa</small></h1>
@endsection
@section('content')
    <section id="persetujuan-frs">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body"
                               data-ic-get-from="/master/mahasiswa/create" title="Tambah Mahasiswa"
                               class="btn btn-default form-control"><i class="fa fa-plus-circle"></i> Tambah</a>&nbsp;
                            <label for="ta">Filter:&nbsp;</label>
                            <select class="form-control" id="jurusan">
                                {!! load_select('ta', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                                    0, [], ['Pilih Jurusan'], true) !!}
                            </select>
                            <input name="angkatan" id="angkatan" class="form-control" type="text" placeholder="Angkatan?" maxlength="4">
                            <a onclick="PFRS.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="daftar-mhs-ngaju" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('akma.persetujuanFRS.getDT') }}"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="PFRS.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="nomor_induk" data-sortable="true" data-visible="true">Nomor Induk</th>
                                <th data-field="nama" data-sortable="true">Nama</th>
                                <th data-field="tahun_masuk" data-sortable="true">Tahun Masuk</th>
                                <th data-field="jenis_kelamin" data-sortable="true">Jenis Kelamin</th>
                                <th data-field="status_FRS" data-sortable="true" data-formatter="PFRS.loadStatus">Status FRS</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('late-script')
<script type="text/javascript">
    var PFRS = {
        init: function() {
            $spp = $('#daftar-mhs-ngaju');
            $spp.bootstrapTable();
            $spp.on('load-success.bs.table', function(e,data){
                PFRS.attachIC();
            });
        },
        loadStatus: function(value, row, index) {
            var a = [];
            if(row['status_FRS']=='{{ \Stmik\RencanaStudi::STATUS_DRAFT }}') {
                a[0] = '<a data-ic-replace-target=true title="Klik Untuk Menyetujui" class="btn btn-xs bg-red">Draft!</a>';
            } else {
                a[0] = '<a data-ic-replace-target=true title="Klik Untuk Membatalkan Persetujuan" class="btn btn-xs bg-green">Disetujui!</a>';
            }
            a[1] = '<a title="Klik melihat KRS" class="btn btn-xs bg-black">KRS</a>';
            return a.join('&nbsp;');
        },
        addFilter: function (p) {
            p.filter = {
                'jurusan': $('#jurusan').val(),
                'angkatan': $('#angkatan').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#daftar-mhs-ngaju').bootstrapTable('refresh');
        },
        onEditSuccess: function() {
            $('#daftar-mhs-ngaju').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#daftar-mhs-ngaju tbody'));
        }
    };
    $(document).ready(function () {
        PFRS.init();
    });
</script>
@endpush