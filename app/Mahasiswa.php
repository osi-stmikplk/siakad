<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Mahasiswa
 * User: Toni
 * @package App
 */
class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nomor_induk';
    public $incrementing = false;

    const STATUS_AKTIF = 'A';
    const STATUS_CUTI = 'C';
    const STATUS_DROP_OUT = 'D';
    const STATUS_KELUAR = 'K';
    const STATUS_LULUS = 'L';
    const STATUS_NON_AKTIF = 'N';
    const STATUS_PINDAH = 'P';

    /**
     * Link ke nama jurusan dll.
     * @return BelongsTo
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * dosenPembimbing merupakan hubungan many-to-many dengan Dosen, karena nilai FK pada table pembimbing adalah
     * default maka tidak dibutuhkan untuk menentukan pula nama field FK disini, kecuali nama table yang custom
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dosenPembimbing()
    {
        return $this->belongsToMany(Dosen::class, 'pembimbing');
    }

    /**
     * Memiliki rencana studi apa saja mahasiswa ini?
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rencanaStudi()
    {
        return $this->hasMany(RencanaStudi::class, 'mahasiswa_id');
    }

    public function setTglLahirAttribute($value)
    {
        $this->attributes['tgl_lahir'] = convert_date_to('d-m-Y', $value);
    }

    public function getTglLahirAttribute($value)
    {
        return convert_date_to('Y-m-d', $value, 'd-m-Y');
    }

    /**
     * Informasi tentang login user ybs
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'owner');
    }
}
