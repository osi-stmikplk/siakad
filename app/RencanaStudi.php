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

    const STATUS_DRAFT = 'DRAFT';
    const STATUS_DISETUJUI = 'DISETUJUI';

    /**
     * Milik siapa rencana studi ini?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function setTglPengisianAttribute($value)
    {
        $this->attributes['tgl_pengisian'] = convert_date_to('d-m-Y', $value);
    }

    public function getTglPengisianAttribute($value)
    {
        return convert_date_to('Y-m-d', $value, 'd-m-Y');
    }

    public function setTglPengajuanAttribute($value)
    {
        $this->attributes['tgl_pengajuan'] = convert_date_to('d-m-Y', $value);
    }

    public function getTglPengajuanAttribute($value)
    {
        return convert_date_to('Y-m-d', $value, 'd-m-Y');
    }

    /**
     * dapatkan id untuk rencana studi, pastikan untuk melakukan setting tahun ajaran dan mahasiswa id lebih dahulu!
     * @return string
     */
    public function generateId()
    {
        return $this->tahun_ajaran . $this->mahasiswa_id;
    }
}
