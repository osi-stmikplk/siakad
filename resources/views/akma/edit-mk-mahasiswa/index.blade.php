@extends($layout)

@section('content-header')
    <h1>Edit MK Mahasiswa<small>demi keberjayaan bersama</small></h1>
@endsection

@section('content')
    <section id="edit-mk-mahasiswa">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="box-body">
                        <p>Pilihan pencetakan tambahan:
                            <a target="_blank" href="#" id="cmdCetakFRS"
                               title="Cetak Formulir Rencana Studi"
                               class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Cetak FRS</a>
                            <a id="cmdRiwayatAkademik" data-toggle="modal" data-target="#modal-util"
                               data-ic-target="#modal-util-body"
                               data-ic-get-from="/mhs/hasilStudy/ips"
                               data-ic-include="#nim"
                               data-ic-trigger-on="nim-sudah-tersedia"
                               title="Indek Prestasi Sementara Per Semester"
                               class="btn btn-primary">Riwayat Akademik</a>
                            <a id="cmdTranskrip" target="_blank" href="#"
                               class="btn btn-info">Transkrip</a>
                        </p>
                        <form id="dt-toolbar" class="form-inline" role="form">
                            <label for="ta">Filter:&nbsp;</label>
                            <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" class="form-control">
                            <select class="form-control" id="ta">
                                {!! load_select('ta', \Stmik\Factories\ReferensiAkademikFactory::getTALists(),
                                    0, [], ['Pilih Tahun Ajaran'], true) !!}
                            </select>
                            <select class="form-control" id="jurusan">
                                {!! load_select('ta', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                                    0, [], ['Pilih Jurusan'], true) !!}
                            </select>
                            <select class="form-control" id="tampil">
                                {!! load_select('tampil', ['MK Terpilih', 'MK Belum Terpilih', 'Semua'],
                                    -1, [], ['Pilih Filter MK'], true) !!}
                            </select>
                            <a onclick="FRSan.sendFilter(event)" id="send-filter" class="form-control btn btn-sm btn-warning"><i class="fa fa-exchange"></i> </a>
                        </form>
                        <table id="mhs-mk-frs" class="table"
                               data-ic-on-error="FRSan.onError(xhr)"
                               data-toolbar="#dt-toolbar"
                               data-url="{{ route('mhs.frs.getDT') }}"
                               data-unique-id="id"
                               data-pagination="true"
                               data-classes="table table-hover table-condensed"
                               data-striped="true"
                               data-side-pagination="server"
                               data-page-list="[5, 10, 20, 50, 100, 200]"
                               data-search="true"
                               data-show-toggle="true"
                               data-query-params="FRSan.addFilter"
                               data-mobile-responsive="true">
                            <thead>
                            <tr>
                                <th rowspan="2" data-field="id" data-visible="false">ID</th>
                                <th rowspan="2" data-field="semester" data-sortable="false">Semester</th>
                                <th colspan="7">Mata Kuliah</th>
                                <th rowspan="2" data-field="terpilih" data-formatter="FRSan.loadStatus">Aksi</th>
                            </tr>
                            <tr>
                                <th data-field="kode" data-sortable="true">Kode</th>
                                <th data-field="nama" data-sortable="true">Nama</th>
                                <th data-field="sks" data-sortable="true">SKS</th>
                                <th data-field="kelas" data-sortable="false">Kelas</th>
                                <th data-field="quota" data-sortable="false">Quota</th>
                                <th data-field="jumlah_peminat" data-sortable="false">Peminat</th>
                                <th data-field="jumlah_pengambil" data-sortable="false">Pengambil</th>
                            </tr>
                            </thead>
                        </table>
                        <p>
                            <span class="label label-warning">NB:</span>
                            Isikan Nomor Induk Mahasiswa dan tentukan jurusan di bagian filter serta lakukan filtering
                            ulang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('late-script')
<script type="text/javascript">
    var FRSan = {
        init: function() {
            $spp = $('#mhs-mk-frs');
            $spp.bootstrapTable();
            $spp.on('load-success.bs.table', function(e,data){
                FRSan.attachIC();
            });
        },
        loadStatus: function(value, row, index) {
            if(row['terpilih']==1) {
                return '<a data-ic-replace-target=true data-ic-post-to="/mhs/frs/batalkanPemilihanKelasIni/' + row['id']
                        + '" class="btn btn-xs bg-red" data-ic-include="#nim" '
                        + ' data-ic-confirm="Yakin untuk membatalkan pemilihan kelas ini?" title="Batalkan Pemilihan Kelas Ini">&nbsp;<i class="fa fa-flag">'
                        + '</i> Terpilih</a>';
            } else {
                return '<a data-ic-replace-target=true data-ic-post-to="/mhs/frs/pilihKelasIni/' + row['id']
                        + '" class="btn btn-xs bg-green" data-ic-include="#nim"'
                        + ' data-ic-confirm="Yakin memilih ini?" title="Pilih Kelas Ini">&nbsp;<i class="fa fa-check-circle">'
                        + '</i> Pilih</a>';

            }
        },
        loadAksi: function(value, row, index) {

        },
        addFilter: function (p) {
            p.filter = {
                'jurusan' : $('#jurusan').val(),
                'tampil' : $('#tampil').val(),
                'nim': $('#nim').val(),
                'ta' : $('#ta').val()
            };
            return p;
        },
        sendFilter: function (e) {
            $('#mhs-mk-frs').bootstrapTable('refresh');
        },
        attachIC: function () {
            Intercooler.processNodes($('table#mhs-mk-frs tbody'));
        },
        onError: function(xhr) {
            TSSTMIK.alertAboutErrorMsg(xhr.responseText);
        },
        padaSetelahMemilih: function(elt, id, peminat, pengambil, terpilih) {
            // update berdasarkan id
            $('#mhs-mk-frs').bootstrapTable('updateByUniqueId', {
                id: id,
                row: {
                    jumlah_peminat: peminat,
                    jumlah_pengambil: pengambil,
                    terpilih: terpilih
                }
            });
            // attach lagi karena setelah proses rewrite di atas, intercoolerjs hilang :(
            FRSan.attachIC();
        }
    };
    $(document).ready(function () {
        FRSan.init();
        $('#mhs-mk-frs').on('padaSetelahMemilih', FRSan.padaSetelahMemilih);
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
        $('#cmdCetakFRS').on('click', function(e) {
            nim = $('#nim').val();
            if(nim.trim().length <= 0) {
                alert("Tentukan dulu NIM yang ingin di proses!");
                return false;
            }
            $(this).attr('href', '/mhs/frs/cetakKRS/'+nim);
            return true;
        })
    });
</script>
@endpush