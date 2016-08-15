@extends($layout)

@section('content-header')
    <h1>Filter Mata Kuliah Double<small>pilih MK yang tampil di transkrip nilai akhir</small></h1>
@endsection

@section('content')
    <section id="filter-mk-double">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <a id="cmdRiwayatAkademik" data-toggle="modal" data-target="#modal-util"
                               data-ic-target="#modal-util-body"
                               data-ic-get-from="/mhs/hasilStudy/ips"
                               data-ic-include="#nim"
                               data-ic-trigger-on="nim-sudah-tersedia"
                               title="Indek Prestasi Sementara Per Semester"
                               class="form-control btn btn-primary">Riwayat Akademik</a>
                            <a id="cmdTranskrip" target="_blank" href="#"
                               class="form-control btn btn-info">Transkrip</a>
                            <label for="ta">Filter:&nbsp;</label>
                            <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" class="form-control">
                            <select class="form-control" id="ta">
                                {!! load_select('ta', \Stmik\Factories\ReferensiAkademikFactory::getTALists(),
                                    0, [], ['Pilih Tahun Ajaran'], true) !!}
                            </select>
                            <a onclick="KHS.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="mhs-hasil-study" class="table"
                               data-toolbar="#dt-toolbar"
                               data-url="/mhs/hasilStudy/getDT"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="KHS.addFilter"
                               data-unique-id="ris_id"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th data-field="ris_id" data-visible="false">RISID</th>
                                <th data-field="tahun_ajaran" data-sortable="true" data-visible="true">Tahun Ajaran</th>
                                <th data-field="semester" data-sortable="true">Semester</th>
                                <th data-field="kode_mata_kuliah" data-sortable="true">Kode Mata Kuliah</th>
                                <th data-field="mata_kuliah" data-sortable="true">Mata Kuliah</th>
                                <th data-field="sks" data-sortable="true">SKS</th>
                                <th data-field="nilai_huruf" data-sortable="true">Nilai Huruf</th>
                                <th data-field="nilai_angka" data-sortable="true" data-visible="false">Nilai Angka</th>
                                <th data-field="status_lulus" data-sortable="true">Kelulusan</th>
                                <th data-field="tampil_di_transkrip" data-sortable="true" data-formatter="KHS.loadStatus">Status</th>
                            </tr>
                            </thead>
                        </table>
                        <p>
                            <span class="label label-info">NB:</span>
                            Apabila terdapat dua MK berkode sama dengan nilai berbeda, yang ditampilkan adalah yang
                            paling tinggi. Di lain pihak, apabila status adalah DISEMBUNYIKAN maka pasti tidak akan
                            ditampilkan/terpilih untuk ditampilkan di transkrip nilai; apapun nilainya.
                        </p>
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
        loadStatus: function(value, row, index) {
            var a = [];
            if(row['tampil_di_transkrip']== {{ \Stmik\RincianStudi::STATUS_TAMPIL_DI_TRANSKRIP_TDK }}) {
                a[0] = '<a data-ic-replace-target=true data-ic-post-to="/akma/mkdouble/status/'+row['ris_id']+ '" ' +
                        'data-ic-confirm="Yakin untuk menampilkan di transkrip?" ' +
                        'title="Klik Untuk Menampilkan Nilai Ini" class="btn btn-xs bg-red">DISEMBUNYIKAN!</a>';
            } else {
                a[0] = '<a data-ic-replace-target=true data-ic-post-to="/akma/mkdouble/status/'+row['ris_id']+ '" ' +
                        'data-ic-confirm="Yakin untuk tidak menampilkan di transkrip?" ' +
                        'title="Klik Untuk Tidak Menampilkan Nilai Ini" class="btn btn-xs bg-green">TAMPIL!</a>';
            }
//            a[1] = row['tampil_di_transkrip'];
//            a[1] = '<a target="_blank" href="/mhs/frs/cetakKRS/'+row['nomor_induk']+'" title="Klik melihat KRS" class="btn btn-xs bg-black">KRS</a>';
            return a.join('&nbsp;');
        },
        addFilter: function (p) {
            p.filter = {
                'nim': $('#nim').val(),
                'ta' : $('#ta').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#mhs-hasil-study')
                    .bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#mhs-hasil-study tbody'));
        },
        padaSetelahReset: function(elt, id, statusTampil) {
            $('#mhs-hasil-study').bootstrapTable('updateByUniqueId', {
                id: id,
                row: {
                    tampil_di_transkrip: statusTampil
                }
            });
            // attach lagi karena setelah proses rewrite di atas, intercoolerjs hilang :(
            KHS.attachIC();
        }
    };
    $(document).ready(function () {
        KHS.init();
        $('#mhs-hasil-study').on('padaSetelahReset', KHS.padaSetelahReset);
        $('#cmdTranskrip').on('click', function(e) {
            nim = $('#nim').val();
            if(nim.trim().length <= 0) {
                alert("Tentukan dulu NIM yang ingin di proses!");
                return false;
            }
            $(this).attr('href', '/mhs/hasilStudy/ipk/'+nim);
            return true;
        });
        $('#cmdRiwayatAkademik').on('click', function(e) {
            nim = $('#nim').val();
            if(nim.trim().length <= 0) {
                alert("Tentukan dulu NIM yang ingin di proses!");
                return false;
            }
            $(this).trigger('nim-sudah-tersedia');
            return true;
        });
    });
</script>
@endpush