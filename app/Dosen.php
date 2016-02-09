<?php
namespace Stmik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Dosen
 * User: Toni
 * @package App
 */
class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'nomor_induk';
    public $incrementing = false;

    /**
     * Link ke nama jurusan dll.
     * @return BelongsTo
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Sama halnya dengan relasi dosenPembimbing, maka di sini dibuat sebuah relasi di antara dosen dan mahasiswa yang
     * dibimbingnya.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function mahasiswaDibimbing()
    {
        return $this->belongsToMany(Mahasiswa::class, 'pembimbing');
    }
}
