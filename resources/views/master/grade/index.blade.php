@extends($layout)
@section('content-header')
    <h1>Standar Grade Penilaian<small>standar itu wajib</small></h1>
@endsection
@section('content')
    <section id="master-grade">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body"
                               data-ic-get-from="/master/grade/create" title="Tambah Standar Grade"
                               class="btn btn-default form-control"><i class="fa fa-plus-circle"></i> Tambah</a>&nbsp;
                        </form>
                        <table id="mater-grade" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('master.grade.getDT') }}"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="MasterGrade.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="false" data-visible="false" rowspan="2">ID</th>
                                <th colspan="2">Rentang TA</th>
                                <th colspan="2">Nilai A</th>
                                <th colspan="2">Nilai AB</th>
                                <th colspan="2">Nilai B</th>
                                <th colspan="2">Nilai BC</th>
                                <th colspan="2">Nilai C</th>
                                <th colspan="2">Nilai D</th>
                                <th colspan="2">Nilai E</th>
                                <th data-width="100px" data-formatter="MasterGrade.loadAksi" data-events="eventAksi" rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th data-field="tahun_ajaran_mulai" data-sortable="true" data-visible="true">Mulai</th>
                                <th data-field="tahun_ajaran_berakhir" data-sortable="true" data-visible="true">Berakhir</th>
                                <th data-field="minimal_a" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_a" data-sortable="false" data-visible="true">Angka</th>
                                <th data-field="minimal_ab" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_ab" data-sortable="false" data-visible="true">Angka</th>
                                <th data-field="minimal_b" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_b" data-sortable="false" data-visible="true">Angka</th>
                                <th data-field="minimal_bc" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_bc" data-sortable="false" data-visible="true">Angka</th>
                                <th data-field="minimal_c" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_c" data-sortable="false" data-visible="true">Angka</th>
                                <th data-field="minimal_d" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_d" data-sortable="false" data-visible="true">Angka</th>
                                <th data-field="minimal_e" data-sortable="false" data-visible="true">Min</th>
                                <th data-field="angka_e" data-sortable="false" data-visible="true">Angka</th>
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
    var MasterGrade = {
        init: function() {
            $spp = $('#mater-grade');
            $spp.bootstrapTable();
            $spp.on('load-success.bs.table', function(e,data){
                MasterGrade.attachIC();
            });
        },
        loadAksi: function(value, row, index) {
            return [
                '<a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body" ' +
                'title="Edit Grade Ini" data-ic-get-from="/master/grade/edit/' + row['id'] + '"' +
                ' class="btn btn-xs bg-blue"><i class="fa fa-edit"></i></a>',
                '<a title="Hapus Data Mahasiswa Ini" data-ic-delete-from="/master/grade/delete/' + row['id'] + '"' +
                    ' data-ic-target="closest tr" data-ic-confirm="Yakin menghapus data grade ini?" ' +
                    ' class="btn btn-xs bg-red-active"><i class="fa fa-trash"></i></a>'
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
            $('#mater-grade').bootstrapTable('refresh');
        },
        onEditSuccess: function() {
            $('#mater-grade').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#mater-grade tbody'));
        }
    };
    $(document).ready(function () {
        MasterGrade.init();
    });
</script>
@endpush