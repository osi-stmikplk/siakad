<?php

namespace Stmik;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stmik\Factories\MahasiswaFactory;

/**
 * Class MahasiswaUtkAkma ini adalah class khusus model yang digunakan oleh bagian akma saat akan melakukan
 * create dan update mahasiswa.
 * User: Toni
 * @package App
 */
class MahasiswaUtkAkma extends Mahasiswa
{
    /**
     * Lakukan secara explisit agar lebih mudah dalam proses pembuatan dan update mahasiswa.
     * @var array
     */
    protected $fillable = ['alamat', 'hp', 'nomor_induk', 'tempat_lahir', 'tgl_lahir',
        'jenis_kelamin', 'alamat', 'hp', 'agama', 'tahun_masuk', 'status', 'status_awal_masuk',
        'jurusan_id', 'nama'];
}
