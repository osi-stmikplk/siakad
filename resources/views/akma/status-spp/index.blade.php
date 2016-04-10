@extends($layout)
@section('content-header')
    <h1>Status Pembayaran SPP<small>status pelunasan</small></h1>
@endsection
@section('content')
    <section id="status-spp">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <label for="ta">Filter:&nbsp;</label>
                            <select class="form-control" id="ta">
                                {!! load_select('ta', \Stmik\Factories\ReferensiAkademikFactory::getTALists(),
                                    0, [], ['Pilih Tahun Ajaran'], true) !!}
                            </select>
                            <select class="form-control" id="jurusan">
                                {!! load_select('ta', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                                    0, [], ['Pilih Jurusan'], true) !!}
                            </select>
                            <a onclick="StSPP.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="spp-data-table" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('akma.spp.getDT') }}"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="StSPP.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="nomor_induk" data-sortable="true" data-visible="true">Nomor Induk</th>
                                <th data-field="nama" data-sortable="true">Nama</th>
                                {{--<th data-field="tahun_ajaran" data-sortable="true">TA</th>--}}
                                {{--<th data-field="status_bayar" data-sortable="true">Status Pelunasan</th>--}}
                                {{--<th data-field="jenis_aturan" data-sortable="true">Jenis Aturan</th>--}}
                                <th data-width="100px" data-formatter="StSPP.loadAksi" data-events="eventAksi">Aksi</th>
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
    function LoadBT() {
        $spp = $('#spp-data-table');
        $spp.bootstrapTable();
        $spp.on('load-success.bs.table', function(e,data){
            StSPP.attachIC();
        });

    }
    $(document).ready(function () {
        TSSTMIK.loadBootstrapTableScript(LoadBT);
    });
    var StSPP = {
        loadAksi: function(value, row, index) {
            a = '';
            taval = $('#ta').val();
            if(taval==null) {
                return '<i class="fa fa-exclamation-triangle"></i> PilihTA';
            }
            if(row['status_bayar']==null || row['status_bayar']==0) {
                @include('akma.status-spp._btn-aksi', [
                    'aksiLunasi'=>true,'forjs'=>true])
            }
            @include('akma.status-spp._btn-aksi', [
                'aksiLunasi'=>false,'forjs'=>true])
        },
        addFilter: function (p) {
            p.filter = {
                'ta' : $('#ta').val(),
                'jurusan': $('#jurusan').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#spp-data-table').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#spp-data-table tbody'));
        }
    };
</script>
@endpush