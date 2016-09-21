<form role="form" name="frmInputAbsen" id="frmInputAbsen"
      data-ic-post-to="{{ route('akma.nilai-mahasiswa.simpan', ['kelas'=>$kelas]) }}"
      data-ic-confirm="Yakin untuk menyimpan hasil entry nilai Mahasiswa?"
>
    <table class="table table-hover table-condensed">
        <thead>
        <tr>
            <th rowspan="2">NIM</th>
            <th rowspan="2">Nama</th>
            <th colspan="5">Nilai</th>
        </tr>
        <tr>
            <th>Tugas</th>
            <th>UTS</th>
            <th>Praktikum</th>
            <th>UAS</th>
            <th>Nilai</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mahasiswaPengambil as $m)
            <tr>
                <td>{{ $m->nomor_induk }}</td>
                <td>{{ $m->nama }}</td>
                <td><input maxlength="5" style="width: 50px" class="form-control" name="tugas[{{ $m->nomor_induk }}]"
                           id="tugas.{{ $m->nomor_induk }}" value="{{ $m->nilai_tugas }}"></td>
                <td><input maxlength="5" style="width: 50px" class="form-control" name="uts[{{ $m->nomor_induk }}]"
                           id="uts.{{ $m->nomor_induk }}" value="{{ $m->nilai_uts }}"></td>
                <td><input maxlength="5" style="width: 50px" class="form-control" name="praktikum[{{ $m->nomor_induk }}]"
                           id="praktikum.{{ $m->nomor_induk }}" value="{{ $m->nilai_praktikum }}"></td>
                <td><input maxlength="5" style="width: 50px" class="form-control" name="uas[{{ $m->nomor_induk }}]"
                           id="uas.{{ $m->nomor_induk }}" value="{{ $m->nilai_uas }}"></td>
                <td><input maxlength="5" style="width: 50px" class="form-control" name="nilai[{{ $m->nomor_induk }}]"
                           id="nilai.{{ $m->nomor_induk }}" value="{{ $m->nilai_akhir }}"></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8">
                <input type="hidden" name="ris[{{ $m->nomor_induk }}]" value="{{ $m->rincian_studi_id }}">
                <button class="btn btn-primary" type="submit">Masukkan Nilai!</button>
            </td>
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