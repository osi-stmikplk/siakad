<?php
/**
 * Fungsi untuk membantu berbagai proses
 * User: toni
 * Date: 25/05/15
 * Time: 14:05
 */
if(!function_exists('load_input_value'))
{
    /**
     * Kita gunakan ini di bagian untuk melakukan setting terhadap value sebuah inputan!
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $field
     * @param mixed $initValue nilai awal saat insialisasi, hanya saat $model = null
     */
    function load_input_value($model,
                              $field,
                              $initValue=null)
    {
        $value = old($field);
        // check apakah ini adalah editing yang tidak langsung dimasukkan nilainya?
        if($value!==null)
        {
            return $value;
        }
        // bila tidak (awal mengedit) maka nilai field ada
        // kembalikan saja nilainya!
        return $model===null? $initValue : $model->{$field};
    }
}
if(!function_exists("load_select"))
{
    /**
     * Load sebuah list!
     * Sebagai contoh:
     * {!! load_select('updetan_atas', $kandidat, $kandidatTerpilih, ['class'=>"form-control"]) !!}
     * @param string $nama nama si select
     * @param array $kandidat kendidat items yang akan di generate
     * @param array|int $terpilih data yang terpilih
     * @param array $options opsi tambahan untuk select
     * @param array $addTop penambahan ke bagian paling atas untuk penjelasan. Tapi bila nilai index = 0 maka item ini tidak memiliki value
     * @return string kembalian hasil genearte
     */
    function load_select($nama, $kandidat, $terpilih, array $options=[], $addTop=['Pilih Pilihan'], $onlyOption=false)
    {
        $gotSelected = false;
        // generate attributes
        $attrs = "";
        if(count($options)>0)
        {
            foreach ($options as $attr => $value) {
                $attrs .= " $attr=\"$value\"";
            }
        }

        // jadikan array untuk terpilih bila bukan array
        if(!is_array($terpilih))
        {
            $terpilih = [$terpilih];
        }
        elseif(count($terpilih)==0)
        {
            $terpilih = [0];
        }
        $terpilih = array_flip($terpilih);

        // generate option
        $opt = "";
        foreach ($kandidat as $key=>$value) {
            if(array_key_exists($key, $terpilih))
            {
                $opt.="<option selected value=\"{$key}\">{$value}</option>";
                $gotSelected = true;
            }
            else
            {
                $opt.="<option value=\"{$key}\">{$value}</option>";
            }
        }

        // apakah ada tambahan di bagian atas?
        if($addTop!=null)
        {
            $top = "";
            if(is_array($addTop))
            {
                $top =$addTop[0];
            }
            else
            {
                $top = $addTop;
            }
//            foreach($addTop as $key=>$value)
//            {
////                if($key!==0) // jangan berikan nilai!
////                {
////                    $opt="<option value=\"{$key}\">{$value}</option>".$opt;
////                }
////                else
////                {
            if($gotSelected)
            {
                $opt="<option value=\"\" disabled>{$top}</option>".$opt;
            }
            else
            {
                $opt="<option value=\"\" disabled selected>{$top}</option>".$opt;
                $gotSelected = true;
            }
////                }
//            }
        }

        // lakukan pengembalian!
        return $onlyOption? $opt: "<select id=\"$nama\" name=\"$nama\"$attrs>$opt</select>";
    }
}

if(!function_exists('load_select_model'))
{
    /**
     * Load select/drop down tapi disini mengambil model langsung untuk mendapatkan kandidat yang terpilih, berbeda
     * dengan load_select
     * @param string $nama nama dari field
     * @param array $kandidat kandidat items yang akan digenerate
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param array $options opsi tambahan untuk select
     * @param array $addTop tambahan untuk menambah di bagian atas dropdown, bila di set dengan 0 maka nilai ini tidak memiliki nilai
     * @param bool $onlyOption apakah hanya akan mengembalikan options saja tanpa ditutup tag <select></select>?
     * @return string kembalian hasil gnerate
     */
    function load_select_model($nama, $kandidat, $data, array $options=[], $addTop=['Pilih Pilihan'], $onlyOption=false)
    {
        $terpilih = load_input_value($data, $nama);
        $terpilih = $terpilih===null? "":$terpilih;
        return load_select($nama, $kandidat, $terpilih, $options, $addTop, $onlyOption);
    }
}
if(!function_exists('load_check_box'))
{
    function load_check_box($nama, $data, $dvalue, $label, array $options = [])
    {
        $value = [];
        $value[] = "name=\"$nama\" id=\"$nama\" type=\"checkbox\" value=\"$dvalue\"";
        $attrs = "";
        if(count($options)>0)
        {
            foreach ($options as $attr => $value) {
                $attrs = " $attr=\"$value\"";
            }
        }
        $value[] = $attrs;
        $terpilih = load_input_value($data, $nama);
        if($terpilih!==null && $terpilih==$dvalue)
        {
            $value[] = 'checked';
        }
        return "<input ". implode(" ", $value) . ">$label";
    }
}
if(!function_exists('load_radio_button'))
{
    function load_radio_button($nama, $data, array $valueLabel, array $options=[])
    {
        $os = [];
        $attrs = "";
        if(count($options)>0)
        {
            foreach ($options as $attr => $value) {
                $attrs = " $attr=\"$value\"";
            }
        }
        $ch = load_input_value($data, $nama);
        foreach($valueLabel as $value=>$label)
        {
            $checked = ($ch==$value? " checked":"");
            $os[] = "<label class=\"radio-inline\">".
                "<input name=\"$nama\" id=\"$nama\" type=\"radio\" value=\"$value\"{$attrs}{$checked}> $label".
                "</label>";
        }
        return implode("",$os);
    }
}
if(!function_exists('convert_date_to'))
{
    /**
     * Lakukan konversi tanggal/date dari suatu format yang di spesifikasikan oleh $formatIn dan target format keluaran
     * adalah dispesifikasikan oleh $formatTarget.
     * @param string $formatIn format masuk dari value
     * @param string $value nilai
     * @param string $formatTarget
     * @return string hasil convert!
     */
    function convert_date_to($formatIn, $value, $formatTarget = 'Y-m-d')
    {
        if(strlen($value)<=0) return null; // kembalikan null karena nilai $value = ""
        $d = date_parse_from_format($formatIn, $value);
        if($d['year']==0 || $d['month']==0 || $d['day']==0) return null; // ini invalid!
        return date($formatTarget, mktime(0,0,0,$d['month'], $d['day'], $d['year']));
    }
}

if(!function_exists('render_error_tag'))
{
    function render_error_tag($id, \Illuminate\Support\ViewErrorBag $errors)
    {
        $hidden = " hidden";
        $msg = "";
        if($errors->hasBag($id))
        {
            $hidden = "";
            $msg = $errors->getBag($id)->first();
        }
        return "<p id='error-$id' class='label label-danger validation-error{$hidden}'>$msg</p>";
    };
}

if(!function_exists('auto_active_menu'))
{
    /**
     * Di beberapa template ada menu yang bisa memperlihatkan active atau tidaknya menu tersebut sesuai dengan route
     * yang aktive waktu itu.
     * @param string|array $route route yang akan di test
     * @param string $classes apakah ada tambahan?
     * @param string  $active_str string untuk penanda aktif atau tidak
     * @return string
     */
    function auto_active_menu($route, $classes, $active_str = 'active', $only_active_str=false)
    {
        $active = '';
        if(!is_array($route))
        {
            if(Request::is($route) || Request::is($route . '/*'))
            {
                $active = "$active_str";
            }
        }
        else
        {
            foreach ($route as $r)
            {
                if(Request::is($r) || Request::is($r . '/*'))
                {
                    $active = "$active_str";
                }
            }
        }
        return !$only_active_str ? "class='$active $classes'": "$active $classes";
    }
}
if(!function_exists('bulan_indonesia'))
{
    /**
     * @param int $bulan
     */
    function bulan_indonesia($bulan)
    {
        $bulanD = (int)$bulan;

        $bulanS = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'Septembar',
            10 => 'Oktober',
            11 => 'Nopember',
            12 => 'Desember',
        ];
        return $bulanS[$bulanD];
    }
}

if(!function_exists('pakai_cache')) {
    /**
     * Lakukan proses penggunaan cache kecuali di local dan test. Load data default dari configurasi untuk nilai berapa
     * lama cache diingat bila nilai dari $lamaDiCache adalah  NULL.
     * @param string $idCache ID untuk cache
     * @param int $lamaDiCache berapa menit nilai disimpan di cache?
     * @param Closure $callAbleFunction closure untuk dijalankan saat mengambil nilai
     * @return mixed $result
     */
    function pakai_cache($idCache, $callAbleFunction, $lamaDiCache = null)
    {
        $result = null;
        $lamaDiCache = ($lamaDiCache===null? \Config::get('siakad.cache-diingat.lama'): $lamaDiCache);
        if(!\App::environment('local', 'test')) {
            $result = \Cache::remember($idCache, $lamaDiCache, $callAbleFunction);
        } else {
            $result = call_user_func($callAbleFunction);
        }
        return $result;
    }
}

if(!function_exists('convert_to_float')) {
    /**
     * Lakukan prose konversi ke float untuk setiap string yang dimasukkan!
     * @param string $value nilai yang akan di konversi!
     * @param string $decimalChar nilai karakter untuk decimal, default adalah titik
     * @return float
     */
    function convert_to_float($value, $decimalChar =".")
    {
        $dot_pos = strrpos($value, ".");
        $com_pos = strrpos($value, ",");
        $sep = ($dot_pos !== false && $dot_pos > $com_pos) ? $dot_pos // ini menggunakan titik sebagai decimal
            : (($com_pos !== false && $com_pos > $dot_pos) ? $com_pos // bila menggunakan koma sebagai decimal
                : false); // atau tidak ada sama sekali

        if(!$sep) { // tidak menggunakan separator
            return floatval(preg_replace("/[^0-9]/", "", $value));
        }
        // ingat bahwa default adalah menggunakan titik
        return floatval(
            preg_replace("/[^0-9]/", "", substr($value, 0, $sep)) . $decimalChar  . // ambil sebelah kiri
            preg_replace("/[^0-9]/", "", substr($value, $sep+1, strlen($value))) // ambil sebelah kanan
        );
    }
}