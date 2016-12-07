<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Grade digunakan untuk entry data grade.
 * Grade di sini adalah fungsi untuk melakukan otomatisasi dan standarisasi grade nilai apakah dapat A, B, C dst serta
 * dilanjutkan dengan angka terhadap nilai akhir mahasiswa yang diinputkan.
 * @package Stmik
 */
class Grade extends Model
{
    protected $table = 'grade';
    protected $guarded = ['id'];

    const GRADE_LULUS = 'LULUS';
    const GRADE_TIDAK_LULUS = 'TIDAK LULUS';

}
