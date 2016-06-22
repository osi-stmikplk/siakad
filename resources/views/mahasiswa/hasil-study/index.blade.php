@extends($layout)
@section('content-header')
    <h1>Hasil Study Mahasiswa<small>tidak pernah menyerah</small></h1>
@endsection
@section('content')
    <section id="status-spp">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <a data-toggle="modal" data-target="#modal-util" data-ic-target="#modal-util-body"
                               data-ic-get-from="/mhs/hasilStudy/ips" title="Indek Prestasi Sementara Per Semester"
                               class="form-control btn btn-primary">Riwayat Akademik</a>
                            <a target="_blank" href="{{ route('mhs.hasilStudy.ipk') }}"
                               class="form-control btn btn-info">Transkrip</a>
                            <label for="ta">Filter:&nbsp;</label>
                            <select class="form-control" id="ta">
                                {!! load_select('ta', \Stmik\Factories\ReferensiAkademikFactory::getTALists(),
                                    0, [], ['Pilih Tahun Ajaran'], true) !!}
                            </select>
                            <a onclick="KHS.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="mhs-hasil-study" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('mhs.hasilStudy.getDT') }}"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="KHS.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="tahun_ajaran" data-sortable="true" data-visible="true">Tahun Ajaran</th>
                                <th data-field="semester" data-sortable="true">Semester</th>
                                <th data-field="kode_mata_kuliah" data-sortable="true">Kode Mata Kuliah</th>
                                <th data-field="mata_kuliah" data-sortable="true">Mata Kuliah</th>
                                <th data-field="sks" data-sortable="true">SKS</th>
                                <th data-field="nilai_huruf" data-sortable="true">Nilai Huruf</th>
                                <th data-field="nilai_angka" data-sortable="true" data-visible="false">Nilai Angka</th>
                                <th data-field="status_lulus" data-sortable="true">Status</th>
                                {{--<th data-field="tahun_ajaran" data-sortable="true">TA</th>--}}
                                {{--<th data-field="status_bayar" data-sortable="true">Status Pelunasan</th>--}}
                                {{--<th data-field="jenis_aturan" data-sortable="true">Jenis Aturan</th>--}}
                                {{--<th data-width="100px" data-formatter="KHS.loadAksi" data-events="eventAksi">Aksi</th>--}}
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
    var KHS = {
        init: function() {
            $spp = $('#mhs-hasil-study');
            $spp.bootstrapTable();
            $spp.on('load-success.bs.table', function(e,data){
                KHS.attachIC();
            });
        },
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
                'ta' : $('#ta').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#mhs-hasil-study').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#mhs-hasil-study tbody'));
        }
    };
    $(document).ready(function () {
        KHS.init();
    });
</script>
@endpush