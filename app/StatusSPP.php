<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

class StatusSPP extends Model
{
    protected $table = 'status_spp';

    const STATUS_BELUM_BAYAR = 0;
    const STATUS_SUDAH_BAYAR = 1;

    /**
     * Siapa mahasiswa ini?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
