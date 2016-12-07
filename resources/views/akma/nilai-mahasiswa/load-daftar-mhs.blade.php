@if(!$kelasPadaTAAktif)
    <p class="alert alert-error">Data kelas bukan pada Tahun Ajaran Aktif, tidak dapat di edit kembali!</p>
@endif
<form role="form" name="frmInputAbsen" id="frmInputAbsen"
      data-ic-post-to="{{ route('akma.nilai-mahasiswa.simpan', ['kelas'=>$kelas]) }}"
      data-ic-confirm="Yakin untuk menyimpan hasil entry nilai Mahasiswa?"
>
    <input type="hidden" name="tahun_ajaran" value="">
    <table class="table table-hover table-condensed">
        <thead>
        <tr>
            <th rowspan="2">NIM</th>
            <th rowspan="2">Nama</th>
            <th colspan="7">Nilai</th>
        </tr>
        <tr>
            <th>Tugas</th>
            <th>UTS</th>
            <th>Praktikum</th>
            <th>UAS</th>
            <th>Akhir</th>
            <th>Grade</th>
            <th>Angka</th>
        </tr>
        </thead>
        <tbody>
        @foreach($mahasiswaPengambil as $m)
            <tr @if($m->status_lulus != \Stmik\Grade::GRADE_LULUS) class="danger" @endif>
                <td>
                    <input type="hidden" name="ris[{{ $m->nomor_induk }}]" value="{{ $m->rincian_studi_id }}">
                    {{ $m->nomor_induk }}
                </td>
                <td>{{ $m->nama }}</td>
                @if($kelasPadaTAAktif)
                    <td><input maxlength="5" style="width: 60px" class="form-control" name="tugas[{{ $m->nomor_induk }}]"
                               id="tugas.{{ $m->nomor_induk }}" value="{{ $m->nilai_tugas }}"></td>
                    <td><input maxlength="5" style="width: 60px" class="form-control" name="uts[{{ $m->nomor_induk }}]"
                               id="uts.{{ $m->nomor_induk }}" value="{{ $m->nilai_uts }}"></td>
                    <td><input maxlength="5" style="width: 60px" class="form-control" name="praktikum[{{ $m->nomor_induk }}]"
                               id="praktikum.{{ $m->nomor_induk }}" value="{{ $m->nilai_praktikum }}"></td>
                    <td><input maxlength="5" style="width: 60px" class="form-control" name="uas[{{ $m->nomor_induk }}]"
                               id="uas.{{ $m->nomor_induk }}" value="{{ $m->nilai_uas }}"></td>
                    <td><input maxlength="5" style="width: 60px" class="form-control" name="akhir[{{ $m->nomor_induk }}]"
                               id="nilai.{{ $m->nomor_induk }}" value="{{ $m->nilai_akhir }}"></td>
                @else
                    <td>{{ $m->nilai_tugas }}</td>
                    <td>{{ $m->nilai_uts }}</td>
                    <td>{{ $m->nilai_praktikum }}</td>
                    <td>{{ $m->nilai_uas }}</td>
                    <td>{{ $m->nilai_akhir }}</td>
                @endif
                <td>{{ $m->nilai_huruf }}</td>
                <td>{{ $m->nilai_angka }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="11">
                @if($kelasPadaTAAktif)
                    <button class="btn btn-primary" type="submit">Masukkan Nilai!</button>
                @else
                    <p class="alert alert-error">Data kelas bukan pada Tahun Ajaran Aktif, tidak dapat di edit kembali!</p>
                @endif
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