{{--
Form ini akan ditampilkan sebagai bagian dari sebuah dialog dalam ajax request!
--}}
<form id="frmSetUser" data-ic-post-to="{{ $action }}"
    class="form-horizontal" role="form" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div id="alerter-success" class="form-group" style="display: none;">
        <div class="col-md-12">
            <div class="alert alert-success">
                <span id="message-success"></span>
            </div>
        </div>
    </div>
    <div id="alerter-error" class="form-group" style="display: none;">
        <div class="col-md-12">
            <div class="alert alert-danger">
                <span id="message-error"></span>
            </div>
        </div>
    </div>
    @if(strtolower($typeOrangNya)!=='mahasiswa')
    <div class="form-group">
        <label for="name" class="col-md-3 control-label">Username</label>
        <div class="col-md-9">
            <input type="text" id="name" class="form-control" name="name"
                   value="{{ load_input_value($data, "name") }}" maxlength="100">
            <div id="error-name" class="error"></div>
        </div>
    </div>
    @else
    {{--Username untuk mahasiswa adalah NIM--}}
    <div class="form-group">
        <label for="namemhs" class="col-md-3 control-label">Username</label>
        <div class="col-md-9">
            <input type="text" id="namemhs" class="form-control" name="namemhs"
                   value="{{ $idOrangIni }}" maxlength="100" readonly>
        </div>
    </div>
    <input type="hidden" value="{{ $idOrangIni }}" name="name">
    @endif
    <div class="form-group">
        <label for="email" class="col-md-3 control-label">Email</label>
        <div class="col-md-9">
            <input type="text" id="email" class="form-control" name="email"
                   value="{{ load_input_value($data, "email") }}" maxlength="255">
            <div id="error-email" class="error"></div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label for="password" class="col-md-3 control-label">Password</label>
        <div class="col-md-9">
            <input type="password" id="password" class="form-control" name="password"
                   maxlength="10">
            <div id="error-password" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="password_ulang" class="col-md-3 control-label">Ketik Ulang Password</label>
        <div class="col-md-9">
            <input type="password" id="password_ulang" class="form-control" name="password_ulang"
                   maxlength="10">
            <div id="error-password_ulang" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">
                Simpan User @include('_ic-indicator')
            </button>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#frmSetUser').on('error.ic', function (evt, elt, stat, str, xhr) {
    $('#alerter-error, #alerter-success').hide();
    TSSTMIK.resetFormErrorMsg('#frmPasien div.error');
    if(xhr.status==422){
        TSSTMIK.showFormErrorMsg(xhr.responseText);
    } else {
        $('#message-error').text(str).closest('div.form-group').show();
    }
});
</script>