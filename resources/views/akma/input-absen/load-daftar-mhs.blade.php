<form role="form" name="frmInputAbsen" id="frmInputAbsen"
  data-ic-post-to="{{ route('akma.absen.simpan', ['kelas'=>$kelas]) }}"
  data-ic-confirm="Yakin untuk melanjutkan pencatatan absensi?"
>
<table class="table table-hover table-condensed">
    <thead>
    <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>H</th>
        <th>I</th>
        <th>S</th>
        <th>TK</th>
        <th>Input</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($mahasiswaPengambil as $m)
        <tr>
            <td>{{ $m->nomor_induk }}</td>
            <td>{{ $m->nama }}</td>
            <td>{{ $m->jumlah_kehadiran }}</td>
            <td>{{ $m->absen_ijin }}</td>
            <td>{{ $m->absen_sakit }}</td>
            <td>{{ $m->absen_tanpa_keterangan }}</td>
            <td><input maxlength="3" style="width: 50px" class="form-control" name="mhs[{{ $m->nomor_induk }}]"
                   id="mhs.{{ $m->nomor_induk }}"></td>
            <td>
                <select class="form-control" name="ket[{{ $m->nomor_induk }}]" id="ket.{{ $m->nomor_induk }}">
                    {!! load_select('m', $pilihanKet, ['H'], [], ['Keterangan'], true) !!}
                </select>
                <input type="hidden" name="ris[{{ $m->nomor_induk }}]" value="{{ $m->rincian_studi_id }}">
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="8"><button class="btn btn-primary" type="submit">Masukkan Nilai!</button></td>
    </tr>
    </tbody>
</table>
</form>

<script type="text/javascript">
$('#frmInputAbsen').on('error.ic', function (evt, elt, stat, str, xhr) {
    if(xhr.status == 422) {
        TSSTMIK.alertAboutErrorMsg(xhr.responseText);
    } else {
        alert('DAMN! UOHUHOH ... Check log ...');
    }
});
@if(isset($msg))
    alert('{{$msg}}');
@endif
</script>