<form id="frmMMhs" data-ic-post-to="{{ $action }}"
    class="form-horizontal" role="form" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('_the_alerter')
    <div class="form-group">
        <label for="nama" class="col-md-3 control-label">Nama</label>
        <div class="col-md-9">
            <input type="text" id="nama" class="form-control" name="nama"
                   value="{{ load_input_value($data, "nama") }}" maxlength="100">
            <div id="error-nama" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="jurusan_id" class="col-md-3 control-label">Jurusan</label>
        <div class="col-md-9">
            {!! load_select_model('jurusan_id', \Stmik\Factories\JurusanFactory::getJurusanLists(),
                $data, ['class'=>'form-control']) !!}
            <div id="error-jurusan_id" class="error"></div>
        </div>
    </div>
    @if(is_null($data))
    <div class="form-group">
        <label for="nomor_induk" class="col-md-3 control-label">Nomor Induk Mahasiswa</label>
        <div class="col-md-9">
            <input type="text" id="nomor_induk" class="form-control" name="nomor_induk"
                   value="{{ load_input_value($data, "nomor_induk") }}" maxlength="12">
            <div id="error-nomor_induk" class="error"></div>
            <p class="help-block">Masukkan Nomor Induk Mahasiswa di sini.</p>
        </div>
    </div>
    @endif
    <div class="form-group">
        <label for="tempat_lahir" class="col-md-3 control-label">Tempat Lahir</label>
        <div class="col-md-9">
            <input type="text" id="tempat_lahir" class="form-control" name="tempat_lahir"
                   value="{{ load_input_value($data, "tempat_lahir") }}" maxlength="100">
            <div id="error-tempat_lahir" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="tgl_lahir" class="col-md-3 control-label">Tgl Lahir</label>
        <div class="col-md-9">
            <div class="input-group">
                <input type="text" id="tgl_lahir" class="form-control col-md-4" name="tgl_lahir"
                       value="{{ load_input_value($data, "tgl_lahir") }}">
                <span class="input-group-addon">dd-mm-yyyy</span>
            </div>
            <div id="error-tgl_lahir" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="jenis_kelamin" class="col-md-3 control-label">Jenis Kelamin</label>
        <div class="col-md-9">
            {!! load_select_model('jenis_kelamin', ['L'=>"Laki-Laki", 'P'=>"Perempuan"], $data, ['class'=>'form-control']) !!}
            <div id="error-jenis_kelamin" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="alamat" class="col-md-3 control-label">Alamat</label>
        <div class="col-md-9">
            <textarea id="alamat" class="form-control" name="alamat">{{ load_input_value($data, "alamat") }}</textarea>
            <div id="error-alamat" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="hp" class="col-md-3 control-label">Nomor HP</label>
        <div class="col-md-9">
            <input type="text" id="hp" class="form-control" name="hp"
                   value="{{ load_input_value($data, "hp") }}" maxlength="50">
            <div id="error-hp" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="agama" class="col-md-3 control-label">Agama</label>
        <div class="col-md-9">
            {!! load_select_model('agama', \Stmik\Factories\AgamaFactory::getAgamaLists(), $data,
            ['class'=>'form-control']) !!}
            <div id="error-agama" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="tahun_masuk" class="col-md-3 control-label">Tahun Masuk</label>
        <div class="col-md-9">
            <input type="text" id="tahun_masuk" class="form-control" name="tahun_masuk"
                   value="{{ load_input_value($data, "tahun_masuk") }}" maxlength="10">
            <div id="error-tahun_masuk" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-md-3 control-label">Status</label>
        <div class="col-md-9">
            {!! load_select_model('status', \Stmik\Factories\MahasiswaFactory::getStatusLists(), $data,
                ['class'=>'form-control']) !!}
            <div id="error-status" class="error"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="status_awal_masuk" class="col-md-3 control-label">Status Awal Masuk</label>
        <div class="col-md-9">
            {!! load_select_model('status_awal_masuk', \Stmik\Factories\MahasiswaFactory::getStatusAwalMasukLists(), $data,
                ['class'=>'form-control']) !!}
            <div id="error-status_awal_masuk" class="error"></div>
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

</script>