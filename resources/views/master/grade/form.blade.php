<form id="frmGrade" data-ic-post-to="{{ $action }}"
    class="form-horizontal" role="form" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('_the_alerter')
    <div class="form-group">
        <label for="tahun_ajaran_mulai" class="col-md-3 control-label">Tahun Ajaran Mulai</label>
        <div class="col-md-9">
            <input type="text" id="tahun_ajaran_mulai" class="form-control" name="tahun_ajaran_mulai"
                   value="{{ load_input_value($data, "tahun_ajaran_mulai") }}" maxlength="5">
            <p class="help-block">Di mulai pada Tahun Ajaran kapan, standar ini digunakan?</p>
            <div id="error-tahun_ajaran_mulai" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="tahun_ajaran_berakhir" class="col-md-3 control-label">Tahun Ajaran Berakhir</label>
        <div class="col-md-9">
            <input type="text" id="tahun_ajaran_berakhir" class="form-control" name="tahun_ajaran_berakhir"
                   value="{{ load_input_value($data, "tahun_ajaran_berakhir") }}" maxlength="5">
            <p class="help-block">Hingga Tahun Ajaran kapan, standar ini digunakan?</p>
            <div id="error-tahun_ajaran_berakhir" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <p class="alert alert-warning text-justify">Pada bagian isian bawah ini, isikan nilai minimal untuk masing-masing grade
                penilaian, untuk nilai yang mendapat grade A, AB, B, BC hingga E. <br>
                <span class="label label-danger"><i class="fa fa-exclamation"></i> </span>
                <strong>Pada bagian isian yang tidak digunakan, isikan nilai minimalnya dengan isian -1 (negative 1)!</strong>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_a" class="col-md-3 control-label">Nilai Minimal A</label>
        <div class="col-md-9">
            <input type="text" id="minimal_a" class="form-control" name="minimal_a"
                   value="{{ load_input_value($data, "minimal_a") }}" maxlength="5">
            <div id="error-minimal_a" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_ab" class="col-md-3 control-label">Nilai Minimal AB</label>
        <div class="col-md-9">
            <input type="text" id="minimal_ab" class="form-control" name="minimal_ab"
                   value="{{ load_input_value($data, "minimal_ab") }}" maxlength="5">
            <div id="error-minimal_ab" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_b" class="col-md-3 control-label">Nilai Minimal B</label>
        <div class="col-md-9">
            <input type="text" id="minimal_b" class="form-control" name="minimal_b"
                   value="{{ load_input_value($data, "minimal_b") }}" maxlength="5">
            <div id="error-minimal_b" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_bc" class="col-md-3 control-label">Nilai Minimal BC</label>
        <div class="col-md-9">
            <input type="text" id="minimal_bc" class="form-control" name="minimal_bc"
                   value="{{ load_input_value($data, "minimal_bc") }}" maxlength="5">
            <div id="error-minimal_bc" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_c" class="col-md-3 control-label">Nilai Minimal C</label>
        <div class="col-md-9">
            <input type="text" id="minimal_c" class="form-control" name="minimal_c"
                   value="{{ load_input_value($data, "minimal_c") }}" maxlength="5">
            <div id="error-minimal_c" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_d" class="col-md-3 control-label">Nilai Minimal D</label>
        <div class="col-md-9">
            <input type="text" id="minimal_d" class="form-control" name="minimal_d"
                   value="{{ load_input_value($data, "minimal_d") }}" maxlength="5">
            <div id="error-minimal_d" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="minimal_e" class="col-md-3 control-label">Nilai Minimal E</label>
        <div class="col-md-9">
            <input type="text" id="minimal_e" class="form-control" name="minimal_e"
                   value="{{ load_input_value($data, "minimal_e") }}" maxlength="5">
            <div id="error-minimal_e" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <p class="alert alert-warning text-justify">Pada bagian isian bawah ini, isikan nilai angka yang didapatkan
                untuk masing-masing grade penilaian, untuk nilai yang mendapat grade A, AB, B, BC hingga E. Misalnya
                untuk nilai grade A mendapat nilai angka 4 dst.<br>
                <i class="fa fa-exclamation-triangle text-danger"></i>
                <strong>Otomatis pada isian minimal dengan nilai -1 maka nilai angka ini tidak akan digunakan.</strong>
            </p>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_a" class="col-md-3 control-label">Nilai Angka A</label>
        <div class="col-md-9">
            <input type="text" id="angka_a" class="form-control" name="angka_a"
                   value="{{ load_input_value($data, "angka_a") }}" maxlength="3,2">
            <div id="error-angka_a" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_ab" class="col-md-3 control-label">Nilai Angka AB</label>
        <div class="col-md-9">
            <input type="text" id="angka_ab" class="form-control" name="angka_ab"
                   value="{{ load_input_value($data, "angka_ab") }}" maxlength="3,2">
            <div id="error-angka_ab" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_b" class="col-md-3 control-label">Nilai Angka B</label>
        <div class="col-md-9">
            <input type="text" id="angka_b" class="form-control" name="angka_b"
                   value="{{ load_input_value($data, "angka_b") }}" maxlength="3,2">
            <div id="error-angka_b" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_bc" class="col-md-3 control-label">Nilai Angka BC</label>
        <div class="col-md-9">
            <input type="text" id="angka_bc" class="form-control" name="angka_bc"
                   value="{{ load_input_value($data, "angka_bc") }}" maxlength="3,2">
            <div id="error-angka_bc" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_c" class="col-md-3 control-label">Nilai Angka C</label>
        <div class="col-md-9">
            <input type="text" id="angka_c" class="form-control" name="angka_c"
                   value="{{ load_input_value($data, "angka_c") }}" maxlength="3,2">
            <div id="error-angka_c" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_d" class="col-md-3 control-label">Nilai Angka D</label>
        <div class="col-md-9">
            <input type="text" id="angka_d" class="form-control" name="angka_d"
                   value="{{ load_input_value($data, "angka_d") }}" maxlength="3,2">
            <div id="error-angka_d" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="angka_e" class="col-md-3 control-label">Nilai Angka E</label>
        <div class="col-md-9">
            <input type="text" id="angka_e" class="form-control" name="angka_e"
                   value="{{ load_input_value($data, "angka_e") }}" maxlength="3,2">
            <div id="error-angka_e" class="error"></div>
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
$('#frmGrade').on('error.ic', function (evt, elt, stat, str, xhr) {
    $('#alerter-error, #alerter-success').hide();
    TSSTMIK.resetFormErrorMsg('#frmGrade div.error');
    if(xhr.status==422){
        TSSTMIK.showFormErrorMsg(xhr.responseText);
    } else {
        $('#message-error').text(str).closest('div.form-group').show();
    }
});
@if(isset($success))
    $('#message-success').text("{{$success}}").closest('div.form-group').show();
    MasterGrade.onEditSuccess(); // trigger it!
@endif
</script>