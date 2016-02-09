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
}
