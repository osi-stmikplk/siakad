<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Model MataKuliah
 * Merupakan model untuk mata kuliah.
 * Ingat bahwa untuk primary key "id" menggunakan format {kode jenjang}{kode program studi}{kode matakuliah}, misalnya
 * untuk E57401MKB50334 maka {E}{57401}{MKB50334}. NOTE: Tidak ada proses yang bisa untuk menentukan nilai suatu record
 * dari nilai ini, karena nilai digunakan agar mudah dalam proses migrasi data dari data lama. Jadi informasi suatu
 * record hanya bisa diambil dari nilai masing-masing field pada record dan entitas berkaitan.
 * User: Toni
 * @package App
 */
class MataKuliah extends Model
{
    protected $table = 'mata_kuliah';
    public $incrementing = false;
    protected $fillable = ['kode', 'nama', 'sks', 'semester', 'jurusan_id'];

    /**
     * Status matakuliah adalah AKTIF
     */
    const STATUS_AKTIF = 'AKTIF';

    /**
     * Status matakuliah adalah HAPUS
     */
    const STATUS_HAPUS = 'HAPUS';

    /**
     * Milik jurusan siapa record ini? dan juga sekalian dengan jenjangnya?
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

}
