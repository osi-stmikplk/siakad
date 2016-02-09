<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RencanaStudi
 * Model untuk RencanaStudi
 * Perhatian untuk nilai PrimaryKey merupakan {tahun ajaran}{nomor induk mahasiswa}, sehingga bukan nilai integer!
 * @package App
 */
class RencanaStudi extends Model
{
    protected $table = 'rencana_studi';
    public $incrementing = false;

    /**
     * Milik siapa rencana studi ini?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
