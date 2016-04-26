{{--tampilkan form untuk setting dosen mata kuliah--}}
<form id="frmMKD" data-ic-post-to="{{ $action }}"
    class="form-horizontal" role="form" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('_the_alerter')
    <div class="form-group">
        <label for="tahun_ajaran" class="col-md-3 control-label">Tahun Ajaran</label>
        <div class="col-md-9">
            {!! load_select_model('tahun_ajaran', \Stmik\Factories\ReferensiAkademikFactory::getTALists(),
                $data, ['class'=>'form-control']) !!}
            <div id="error-tahun_ajaran" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="kelas" class="col-md-3 control-label">Kelas</label>
        <div class="col-md-9">
            <input type="text" id="kelas" class="form-control" name="kelas"
                   value="{{ load_input_value($data, "kelas") }}" maxlength="5">
            <div id="error-kelas" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="quota" class="col-md-3 control-label">Quota</label>
        <div class="col-md-9">
            <input type="text" id="quota" class="form-control" name="quota"
                   value="{{ load_input_value($data, "quota") }}" maxlength="3">
            <p class="help-block">Berapa quota mahasiswa untuk kelas ini?</p>
            <div id="error-quota" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="dosen_id" class="col-md-3 control-label">Dosen Pengampu Kelas</label>
        <div class="col-md-9">
            {!! load_select_model('dosen_id', \Stmik\Factories\DosenFactory::getDosenLists(),
                $data, ['class'=>'form-control']) !!}
            <div id="error-dosen_id" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="jurusan" class="col-md-3 control-label">Jurusan</label>
        <div class="col-md-9">
            <select name="jurusan" id="jurusan" class="form-control"
                data-ic-indicator="#mata_kuliah_indicator"
                data-ic-post-to="{{ route('master.mk.loadBasedOnJurusan') }}"
                data-ic-target="#mata_kuliah_id">
                @if(is_null($data))
                    {!! load_select('jurusan', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                        0, [], ['Pilih Jurusan'], true) !!}
                @else
                    {!! load_select('jurusan', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                        $data->mataKuliah->jurusan->id, [], ['Pilih Jurusan'], true) !!}
                @endif
            </select>
            <div id="error-jurusan" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="mata_kuliah_id" class="col-md-3 control-label">
            Mata Kuliah Diampu <i id="mata_kuliah_indicator" class="fa fa-spin fa-spinner" style="display: none;"></i>
        </label>
        <div class="col-md-9">
            <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control">
                @if(!is_null($data))
                    {!! load_select('mata_kuliah_id', \Stmik\Factories\MasterMataKuliahFactory::getMataKuliahListsBerdasarkan($data->mataKuliah->jurusan->id),
                        $data->mataKuliah->id, [], ['Pilih Mata Kuliah'], true) !!}
                @endif
            </select>
            <div id="error-mata_kuliah_id" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">
                Simpan @include('_ic-indicator')
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#frmMKD').on('error.ic', function (evt, elt, stat, str, xhr) {
    $('#alerter-error, #alerter-success').hide();
    TSSTMIK.resetFormErrorMsg('#frmMKD div.error');
    if(xhr.status==422){
        TSSTMIK.showFormErrorMsg(xhr.responseText);
    } else {
        $('#message-error').text(str).closest('div.form-group').show();
    }
});
@if(isset($success))
    $('#message-success').text("{{$success}}").closest('div.form-group').show();
    DosenKlsMK.onEditSuccess(); // trigger it!
@endif
</script>