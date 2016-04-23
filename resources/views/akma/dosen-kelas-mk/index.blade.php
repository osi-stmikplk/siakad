@extends($layout)
@section('content-header')
    <h1>Kelas, Mata Kuliah & Dosen Pengampunya<small>sesuaikan dengan keahlian</small></h1>
@endsection
@section('content')
    <section id="status-spp">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body"
                               data-ic-get-from="/akma/dkmk/create" title="Pencatatan Baru"
                               class="btn btn-default form-control"><i class="fa fa-plus-circle"></i> Tambah</a>&nbsp;
                            <label for="ta">Filter:&nbsp;</label>
                            <select class="form-control" id="ta">
                                {!! load_select('ta', \Stmik\Factories\ReferensiAkademikFactory::getTALists(),
                                    0, [], ['Pilih Tahun Ajaran'], true) !!}
                            </select>
                            <select class="form-control" id="jurusan">
                                {!! load_select('ta', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                                    0, [], ['Pilih Jurusan'], true) !!}
                            </select>
                            <a onclick="DosenKlsMK.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="kelas-mk-dosen" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('akma.dkmk.getDT') }}"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="DosenKlsMK.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true" data-visible="false">ID</th>
                                <th data-field="tahun_ajaran" data-sortable="true">Tahun Ajaran</th>
                                <th data-field="nama_jurusan" data-sortable="true">Jurusan</th>
                                <th data-field="nama_mk" data-sortable="true">Mata Kuliah</th>
                                <th data-field="nama_dosen" data-sortable="true">Dosen</th>
                                <th data-field="kelas" data-sortable="true">Kelas</th>
                                <th data-field="quota" data-sortable="true">Quota</th>
                                {{--<th data-field="tahun_ajaran" data-sortable="true">TA</th>--}}
                                {{--<th data-field="status_bayar" data-sortable="true">Status Pelunasan</th>--}}
                                {{--<th data-field="jenis_aturan" data-sortable="true">Jenis Aturan</th>--}}
                                <th data-width="100px" data-formatter="DosenKlsMK.loadAksi" data-events="eventAksi">Aksi</th>
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
    var DosenKlsMK = {
        init: function() {
            $spp = $('#kelas-mk-dosen');
            $spp.bootstrapTable();
            $spp.on('load-success.bs.table', function(e,data){
                DosenKlsMK.attachIC();
            });
        },
        loadAksi: function(value, row, index) {
            return [
                '<a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body" ' +
                'title="Edit Dosen Pengampu Kelas" data-ic-get-from="/akma/dkmk/edit/' + row['id'] + '"' +
                ' class="btn btn-xs bg-blue"><i class="fa fa-edit"></i></a>',
                '<a data-ic-confirm="Data yang terhapus tidak dapat dikembalikan, yakin menghapus?" ' +
                'data-ic-target="closest tr" data-ic-delete-from="/akma/dkmk/delete/' + row['id'] + '" title="Hapus ..." ' +
                'class="btn btn-xs bg-red"><i class="fa fa-trash-o"></i></a>'
            ].join('&nbsp;');
        },
        addFilter: function (p) {
            p.filter = {
                'ta' : $('#ta').val(),
                'jurusan': $('#jurusan').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#kelas-mk-dosen').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#kelas-mk-dosen tbody'));
        },
        onEditSucces: function() {
            $('#kelas-mk-dosen').bootstrapTable('refresh');
        }
    };
    $(document).ready(function () {
        DosenKlsMK.init();
    });
</script>
@endpush