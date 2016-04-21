<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model PengampuKelas
 * Perhatian nilai dari Primary Key adalah hasil kalkulasi MD5 dari
 * { id mata kuliah }{ nomor induk dosen }{ tahun ajaran }{ kelas diampu }
 * atau silahkan lihat dari fungsi kalkulasiPK( ... )
 * - Kasus bila terjadi pergantian dosen di tengah prose belajar? Ganti saja id dosen, nilai PK tidak perlu diganti.
 * User Toni
 * @package App
 */
class PengampuKelas extends Model
{
    protected $table = 'pengampu_kelas';
    public $incrementing = false;
    protected $guarded = ['id'];
    protected $fillable = ['tahun_ajaran', 'tgl_penetapan', 'kelas', 'quota', 'dosen_id', 'mata_kuliah_id'];

    /**
     * Proses migrasi memang membuat pusing :D daripada pusing harus entry ulang maka maksimalkan pattern terhadap
     * data yang ada. Selain itu, premature optimisation is the root of evil!
     * @param $mata_kuliah_id
     * @param $nomor_induk_dosen
     * @param $tahun_ajaran
     * @param $kelas_diampu
     * @return string hasil kalkulasi md5 dengan panjang 32 karakter!
     */
    public function kalkulasiPK($mata_kuliah_id, $nomor_induk_dosen, $tahun_ajaran, $kelas_diampu)
    {
        return md5("{$mata_kuliah_id}{$nomor_induk_dosen}{$tahun_ajaran}{$kelas_diampu}");
    }

    /**
     * Siapa dosen yang mengampu kelas ini?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Mata kuliah apa ini?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }
}
