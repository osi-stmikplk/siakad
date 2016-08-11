<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RincianStudi
 * Untuk Model Rincian Studi.
 *
 * Bahwa primaryKey didapatkan dari MD5 {id pengampu kelas}{nim}
 * @package App
 */
class RincianStudi extends Model
{
    protected $table = 'rincian_studi';
    public $incrementing = false;
    public $timestamps = false;

    const STATUS_TAMPIL_DI_TRANSKRIP_YA = 1;
    const STATUS_TAMPIL_DI_TRANSKRIP_TDK = 0;

    /**
     * Nilai dari PK didapatkan dari kalkulasi md5 terhadap nilai $pengampu_kelas_id dan $nim
     * @param $pengampu_kelas_id
     * @param $nim
     * @return string hasil kalkulasi 32 karakter
     */
    public function kalkulasiPK($pengampuKelasId, $nim)
    {
        return md5("{$pengampuKelasId}{$nim}");
    }

    /**
     * Ini rencana studi yang mana?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rencanaStudi()
    {
        return $this->belongsTo(RencanaStudi::class, 'rencana_studi_id');
    }

    /**
     * Ingin mendapatkan kelas, tahun ajaran, mata kuliah dan siapa dosen pengampu?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelasDiambil()
    {
        return $this->belongsTo(PengampuKelas::class, 'kelas_diambil_id');
    }

}
