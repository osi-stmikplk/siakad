<?php
namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Jurusan
 * Ingat bahwa untuk id yaitu yang dijadikan sebagai Primary Key milik Jurusan memiliki format
 * {kode jenjang}{kode program studi} yang tanpa spasi diantaranya.
 * Sebagai contoh C57201 {kode jenjang = C}{kode program studi = 57201}. Alasan ini dilakukan adalah demi kemudahan
 * dalam proses migrasi. Mungkin perlu dipikirkan untuk melakukan proses upgrade nantinya di masa depan.
 * TODO: upgrade nilai jenjang menjadi S1 dibanding menggunakan C!
 * User: Toni
 * @package App
 */
class Jurusan extends Model
{
    protected $table = 'jurusan';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * Link balik ke nama-nama dosen yang ada di suatu jurusan
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'jurusan_id');
    }

    /**
     * Link balik ke nama mahasiswa!
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'jurusan_id');
    }
}
