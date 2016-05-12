<form id="frmDataDiri" data-ic-post-to="{{ $action }}"
    class="form-horizontal" role="form" method="POST" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('_the_alerter')
    <div class="form-group">
        <label for="nomor_induk" class="col-md-3 control-label">Nomor Induk Mahasiswa</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "nomor_induk") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="nama" class="col-md-3 control-label">Nama</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "nama") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="jurusan_id" class="col-md-3 control-label">Jurusan</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ $data->jurusan->jenjang .' - '.$data->jurusan->nama }}</p>
            <div id="error-jurusan_id" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="tempat_lahir" class="col-md-3 control-label">Tempat, Tanggal Lahir</label>
        <div class="col-md-9">
            <p class="form-control-static">{{  load_input_value($data, "tempat_lahir") }}, {{ load_input_value($data, "tgl_lahir") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="jenis_kelamin" class="col-md-3 control-label">Jenis Kelamin</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "jenis_kelamin_string") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="agama" class="col-md-3 control-label">Agama</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "agama") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="tahun_masuk" class="col-md-3 control-label">Tahun Masuk</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "tahun_masuk") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-md-3 control-label">Status</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "status") }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="status_awal_masuk" class="col-md-3 control-label">Status Awal Masuk</label>
        <div class="col-md-9">
            <p class="form-control-static">{{ load_input_value($data, "status_awal_masuk") }}</p>
            <div id="error-status_awal_masuk" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="alamat" class="col-md-3 control-label">Alamat Lengkap</label>
        <div class="col-md-9">
            <textarea id="alamat" class="form-control" name="alamat">{{ load_input_value($data, "alamat") }}</textarea>
            <p class="help-block">Mohon ketikkan alamat lengkap yang benar.</p>
            <div id="error-alamat" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-md-3 control-label">Email</label>
        <div class="col-md-9">
            <input type="text" id="email" class="form-control" name="email"
                   value="{{ $email }}" maxlength="50">
            <p class="help-block">Email adalah komponen penting agar anda bisa menggunakan fasilitas penting di sini.</p>
            <div id="error-email" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="hp" class="col-md-3 control-label">Nomor yang Bisa Dihubungi</label>
        <div class="col-md-9">
            <input type="text" id="hp" class="form-control" name="hp"
                   value="{{ load_input_value($data, "hp") }}" maxlength="50">
            <p class="help-block">Ketikkan di sini nomor telepon, hp yang bisa dihubungi untuk verifikasi.</p>
            <div id="error-hp" class="error"></div>
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

@push('late-script')
<script type="text/javascript">
    $('#frmDataDiri').on('error.ic', function (evt, elt, stat, str, xhr) {
        $('#alerter-error, #alerter-success').hide();
        TSSTMIK.resetFormErrorMsg('#frmDataDiri div.error');
        if(xhr.status==422){
            TSSTMIK.showFormErrorMsg(xhr.responseText);
        } else {
            $('#message-error').text(str).closest('div.form-group').show();
        }
    }).on('success.ic', function() {
        alert('Data telah tersimpan ...');
    });
</script>
@endpush