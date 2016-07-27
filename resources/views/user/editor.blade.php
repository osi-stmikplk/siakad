{{--
tampilan untuk editing user yang login, bisa merubah password dan email, method ada di Controller karena bisa dilakukan
oleh siapa saja yang login.
--}}
<form id="frmUserEdt" data-ic-post-to="{{ $action }}"
      class="form-horizontal" role="form" method="POST" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('_the_alerter')
    <div class="form-group">
        <label for="name" class="col-md-3 control-label">Username</label>
        <div class="col-md-9">
             <p class="form-control-static">{{ $user->name }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-md-3 control-label">Email</label>
        <div class="col-md-9">
            <input type="text" id="email" class="form-control" name="email"
                   value="{{ load_input_value($user, "email") }}" maxlength="50">
            <p class="help-block">Email adalah komponen penting agar anda bisa menggunakan fasilitas penting di sini.</p>
            <div id="error-email" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="curr_password" class="col-md-3 control-label">Password Sekarang</label>
        <div class="col-md-9">
            <input class="form-control" type="password" name="curr_password" id="curr_password">
            <p class="help-block">Ketikkan Password yang saat ini anda gunakan.</p>
            <div id="error-curr_password" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-md-3 control-label">Password Baru</label>
        <div class="col-md-9">
            <input class="form-control" type="password" name="password" id="password">
            <p class="help-block">Ketikkan Password baru.</p>
            <div id="error-password" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="password_confirmation" class="col-md-3 control-label">Ketikkan Ulang Password Baru</label>
        <div class="col-md-9">
            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
            <p class="help-block">Ketikkan ulang password baru anda.</p>
            <div id="error-password_confirmation" class="error"></div>
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
    $('#frmUserEdt').on('error.ic', function (evt, elt, stat, str, xhr) {
        $('#alerter-error, #alerter-success').hide();
        TSSTMIK.resetFormErrorMsg('#frmUserEdt div.error');
        if(xhr.status==422){
            TSSTMIK.showFormErrorMsg(xhr.responseText);
        } else {
            $('#message-error').text(str).closest('div.form-group').show();
        }
    }).on('success.ic', function() {
        alert('Data telah tersimpan ...');
    });
</script>