{{--
Digunakan untuk melakukan render tombol aksi pada setting status SPP. agar dapat menggunakannya maka dibutuhkan variable
@param bool $aksiLunasi - bila untuk render tombol melunasi (true) dan sebaliknya
@param bool $forjs - untuk di render di form buat javascript nya
--}}
<?php $forjs = isset($forjs)?$forjs:false;?>
@if($forjs)
    @if($aksiLunasi==true)
        return '<a data-ic-replace-target=true class="btn btn-sm bg-red" '
            + 'data-ic-confirm="Yakin untuk set nilai ini?" '
            + 'data-ic-post-to="/akma/spp/setStatus/' + row['nomor_induk'] + '/' + taval
            + '" title="Set Terbayar">&nbsp;<i class="fa fa-paypal"></i> Set Lunas <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i></a>';
    @else
        return '<a data-ic-replace-target=true class="btn btn-sm bg-aqua" '
            + 'data-ic-confirm="Yakin untuk mereset nilai ini?" '
            + 'data-ic-post-to="/akma/spp/setStatus/' + row['nomor_induk'] + '/' + taval
            + '" title="Telah Lunas">&nbsp;<i class="fa fa-check-circle"></i> Terlunasi <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i></a>';
    @endif
@else
    {{--
    Kalau disini saat tombol sudah di swap maka render langsung saja
    Bila bukan js maka dibutuhkan
    @param string $nim
    @param string $ta
    --}}
    @if($aksiLunasi==true)
        <a data-ic-replace-target=true class="btn btn-sm bg-red"
           data-ic-confirm="Yakin untuk set nilai ini?"
           data-ic-post-to="/akma/spp/setStatus/{{$nim}}/{{$ta}}"
           title="Set Terbayar">&nbsp;<i class="fa fa-paypal"></i> Set Lunas <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i></a>
    @else
        <a data-ic-replace-target=true class="btn btn-sm bg-aqua"
           data-ic-confirm="Yakin untuk mereset nilai ini?"
           data-ic-post-to="/akma/spp/setStatus/{{$nim}}/{{$ta}}"
           title="Telah Lunas">&nbsp;<i class="fa fa-check-circle"></i> Terlunasi <i class="ic-indicator fa fa-spin fa-spinner" style="display: none;"></i></a>
    @endif
@endif