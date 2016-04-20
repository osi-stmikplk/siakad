@extends($layout)
@section('content-header')
    <h1>Data Mata Kuliah<small>beneran kuliah benaran</small></h1>
@endsection
@section('content')
    <section id="master-mahasiswa">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body"
                               data-ic-get-from="/master/mk/create" title="Tambah Mata Kuliah Baru"
                                class="btn btn-default form-control"><i class="fa fa-plus-circle"></i> Tambah</a>&nbsp;
                            <label for="ta">Filter:&nbsp;</label>
                            <select class="form-control" id="jurusan">
                                {!! load_select('jurusan', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                                    0, [], ['Pilih Jurusan'], true) !!}
                            </select>
                            <select class="form-control" id="status">
                                {!! load_select('status', \Stmik\Factories\MasterMataKuliahFactory::getStatusLists(),
                                    0, [], ['Pilih Status'], true) !!}
                            </select>
                            <a onclick="MasterMK.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="master-mk" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('master.mk.getDT') }}"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="MasterMK.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="id" data-visible="false">ID</th>
                                <th data-field="nama_jurusan" data-sortable="true">Jurusan</th>
                                <th data-field="kode" data-sortable="true">Kode</th>
                                <th data-field="nama" data-sortable="true">Nama</th>
                                <th data-field="sks" data-sortable="true">SKS</th>
                                <th data-field="semester" data-sortable="true">Semester</th>
                                <th data-field="status" data-sortable="true" data-formatter="MasterMK.loadStatus">Status</th>
                                <th data-width="100px" data-formatter="MasterMK.loadAksi" data-events="eventAksi">Aksi</th>
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
    var MasterMK = {
        init: function() {
            $spp = $('#master-mk');
            $spp.bootstrapTable();
            $spp.on('load-success.bs.table', function(e,data){
                MasterMK.attachIC();
            });
        },
        loadStatus: function(value, row, index) {
            if(row['status']=='{{\Stmik\MataKuliah::STATUS_AKTIF}}') {
                @include('master.mata-kuliah._btn-aksi-status', [
                    'statusAktif'=>true,'forjs'=>true])
            } else {
                @include('master.mata-kuliah._btn-aksi-status', [
                    'statusAktif'=>false,'forjs'=>true])
            }
        },
        loadAksi: function(value, row, index) {
            return [
                '<a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body" ' +
                    'title="Edit Mata Kuliah" data-ic-get-from="/master/mk/edit/' + row['id'] + '"' +
                    ' class="btn btn-xs bg-blue"><i class="fa fa-edit"></a>'
            ].join('&nbsp;');
        },
        addFilter: function (p) {
            p.filter = {
                'jurusan': $('#jurusan').val(),
                'status': $('#status').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#master-mk').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#master-mk tbody'));
        }
    };
    $(document).ready(function () {
        MasterMK.init();
    });
</script>
@endpush