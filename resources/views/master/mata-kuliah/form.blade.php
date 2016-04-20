{{--
Form ini akan di load untuk melakukan edit atau menambahkan data matakuliah
--}}
<form id="frmMK" data-ic-post-to="{{ $action }}"
      data-ic-confirm="Yakin untuk melanjutkan?"
    class="form-horizontal" role="form" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include("_the_alerter")
    @if(!is_null($data) && is_object($data))
        {{--Mode edit tampilkan peringatan--}}
    <div id="alerter-info" class="form-group">
        <div class="col-md-12">
            <div class="alert bg-danger">
                <span><i class="fa fa-warning"></i> Hi, merubah data pada Mata Kuliah dapat mengakibatkan sakit jantung,
                    tekanan batin dan gangguan mental akut bagi Mahasiswa yang telah mengambil Mata Kuliah terubah. <br>
                    <b>Yakinkan anda tahu apa yang anda perbuat!</b></span>
            </div>
        </div>
    </div>
    @endif
    <div class="form-group">
        <label for="jurusan_id" class="col-md-3 control-label">Jurusan</label>
        <div class="col-md-9">
            {!! load_select_model('jurusan_id', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                $data, ['class'=>'form-control']) !!}
            <div id="error-jurusan_id" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="kode" class="col-md-3 control-label">Kode Mata Kuliah</label>
        <div class="col-md-9">
            <input type="text" id="kode" class="form-control" name="kode"
                   value="{{ load_input_value($data, "kode") }}" maxlength="20">
            <div id="error-kode" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="nama" class="col-md-3 control-label">Nama Mata Kuliah</label>
        <div class="col-md-9">
            <input type="text" id="nama" class="form-control" name="nama"
                   value="{{ load_input_value($data, "nama") }}" maxlength="255">
            <div id="error-nama" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="sks" class="col-md-3 control-label">Jumlah SKS</label>
        <div class="col-md-9">
            <input type="text" id="sks" class="form-control" name="sks"
                   value="{{ load_input_value($data, "sks") }}" maxlength="4">
            <div id="error-sks" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="semester" class="col-md-3 control-label">Pada Semester</label>
        <div class="col-md-9">
            <input type="text" id="semester" class="form-control" name="semester"
                   value="{{ load_input_value($data, "semester") }}" maxlength="4">
            <div id="error-semester" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">
                Simpan @include("_ic-indicator")
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#frmMK').on('error.ic', function (evt, elt, stat, str, xhr) {
    $('#alerter-error, #alerter-success').hide();
    TSSTMIK.resetFormErrorMsg('#frmMK div.error');
    if(xhr.status==422){
        TSSTMIK.showFormErrorMsg(xhr.responseText);
    } else {
        $('#message-error').text(str).closest('div.form-group').show();
    }
});
@if(isset($success))
    $('#message-success').text("{{$success}}").closest('div.form-group').show();
    $('#master-mk').bootstrapTable('refresh');
@endif
</script>