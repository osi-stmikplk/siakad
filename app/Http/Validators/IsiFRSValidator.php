<?php
/**
 * Digunakan untuk melakukan validasi terhadap berbagai request yang dilakukan oleh Mahasiswa di pengisian validator.
 * User: toni
 * Date: 24/05/16
 * Time: 18:21
 */

namespace Stmik\Http\Validators;


use Illuminate\Support\Arr;
use Stmik\Factories\DosenKelasMKFactory;
use Stmik\PengampuKelas;

class IsiFRSValidator
{
    protected $pengampuKelasFactory;

    public function __construct(DosenKelasMKFactory $dosenKelasMKFactory)
    {
        $this->pengampuKelasFactory = $dosenKelasMKFactory;
    }

    /**
     * Validasi proses pemilihan kelas!
     * Kelas bisa diambil bila:
     * - quota masih belum habis
     * - tidak mengambil kode MK yang sama walaupun beda kelas pada pemilihan di semester yang aktif
     * Dilakukan dengan cara pada bagian validasi:
     *  kelasBisaDiambil:nilai_nim_mahasiswa
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param $validator
     */
    public function kelasBisaDiambil($attribute, $value, $parameters, $validator)
    {
        /** @var PengampuKelas $pengampuKelas */
        $pengampuKelas = $this->pengampuKelasFactory->getDataDosenKelasMKBerdasarkan($value);
        // check bila quota telah tercapai
        if($pengampuKelas->jumlah_pengambil >= $pengampuKelas->quota) {
            return false;
        }
        // check bila MK sudah diambil walaupun beda kelas
        $nim = $parameters[0];
        if($this->pengampuKelasFactory->mataKuliahSamaTelahTerambil($nim, $value)) {
            return false;
        }
        return true;
    }
}