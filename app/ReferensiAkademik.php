<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ReferensiAkademik
 * Ini merupakan referensi akademik, tempat di mana penentuan kalendar akademik yang saat itu aktif dilakukan.
 * User: Toni
 * @package App
 */
class ReferensiAkademik extends Model
{
    protected $table = 'referensi_akademik';
    protected $guarded = ['id'];

    public function setTglMulaiIsiKrsAttribute($value)
    {
        $this->attributes['tgl_mulai_isi_krs'] = convert_date_to('d-m-Y', $value);
    }

    public function getTglMulaiIsiKrsAttribute($value)
    {
        return convert_date_to('Y-m-d', $value, 'd-m-Y');
    }

    public function setTglBerakhirIsiKrsAttribute($value)
    {
        $this->attributes['tgl_berakhir_isi_krs'] = convert_date_to('d-m-Y', $value);
    }

    public function getTglBerakhirIsiKrsAttribute($value)
    {
        return convert_date_to('Y-m-d', $value, 'd-m-Y');
    }
}
