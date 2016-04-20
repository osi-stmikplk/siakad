{{--
Digunakan untuk melakukan render tombol aksi pada setting status Mata Kuliah. agar dapat menggunakannya maka dibutuhkan
variable:
@param bool $aksiHapus - bila untuk render tombol set status jadi hapus (true) dan sebaliknya
@param bool $forjs - untuk di render di form buat javascript nya
--}}
<?php $forjs = isset($forjs)?$forjs:false;?>
@if($forjs)
    @if($statusAktif==true)
        return '<a data-ic-replace-target=true class="btn btn-xs bg-green" '
        + 'data-ic-confirm="Bila di set status Hapus maka MK tidak bisa dipilih lagi, yakin?" '
        + 'data-ic-post-to="/master/mk/setStatus/' + row['id']
        + '" title="Non Aktifkan MK ini">&nbsp;<i class="fa fa-check-circle"></i> Aktif <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i></a>';
    @else
        return '<a data-ic-replace-target=true class="btn btn-xs bg-red" '
        + 'data-ic-confirm="Yakin untuk menampilkan kembali MK ini?" '
        + 'data-ic-post-to="/master/mk/setStatus/' + row['id']
        + '" title="Aktifkan MK ini">&nbsp;<i class="fa fa-close"></i> Terhapus <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i></a>';
    @endif
@else
    {{--
    Kalau disini saat tombol sudah di swap maka render langsung saja
    @param string $id
    @param string $ta
    --}}
    @if($statusAktif==true)
        <a data-ic-replace-target="true" class="btn btn-xs bg-green"
           data-ic-confirm="Bila di set status Hapus maka MK tidak bisa dipilih lagi, yakin?"
           data-ic-post-to="/master/mk/setStatus/{{$id}}"
           title="Non Aktifkan MK ini">&nbsp;<i class="fa fa-check-circle"></i> Aktif <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i>
        </a>
    @else
        <a data-ic-replace-target="true" class="btn btn-xs bg-red"
           data-ic-confirm="Yakin untuk menampilkan kembali MK ini?"
           data-ic-post-to="/master/mk/setStatus/{{$id}}"
           title="Aktifkan MK ini" >&nbsp;<i class="fa fa-close"></i> Terhapus <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i>
        </a>
    @endif
@endif