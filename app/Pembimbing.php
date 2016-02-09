<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model Pembimbing
 * CLASS INI TIDAK DIBUTUHKAN KARENA mekanisme table many-to-many di antara Dosen dan Mahasiswa!
 * Disediakan untuk kebutuhan khusus di masa mendatang.
 * @package App
 */
class Pembimbing extends Model
{
    protected $table = 'pembimbing';

}
