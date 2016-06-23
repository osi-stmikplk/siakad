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
use Stmik\Factories\IsiFRSFactory;
use Stmik\PengampuKelas;

class IsiFRSValidator
{
    protected $pengampuKelasFactory;
    protected $isiFRSFactory;
    protected $validator;

    public function __construct(DosenKelasMKFactory $dosenKelasMKFactory, IsiFRSFactory $isiFRSFactory)
    {
        $this->pengampuKelasFactory = $dosenKelasMKFactory;
        $this->isiFRSFactory = $isiFRSFactory;
    }

    /**
     * Validasi proses pemilihan kelas!
     * Kelas bisa diambil bila:
     * - quota masih belum habis
     * - tidak mengambil kode MK yang sama walaupun beda kelas pada pemilihan di semester yang aktif
     * Dilakukan dengan cara pada bagian validasi:
     *  kelasBisaDiambil:nilai_nim_mahasiswa,tahun_ajarannya
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
            $validator->getMessageBag()->add('kelas_bisa_diambil', 'Quota kelas telah terpenuhi, cari kelas lain');
            return false;
        }
        // check bila MK sudah diambil walaupun beda kelas
        $nim = $parameters[0];
        if($this->pengampuKelasFactory->mataKuliahSamaTelahTerambil($nim, $value)) {
            $validator->getMessageBag()->add('kelas_bisa_diambil', 'Mata Kuliah telah terambil pada kelas yang lain');
            return false;
        }
        // check jumlah SKS terambil?
        $ta = $parameters[1];
        $totalSKS = $this->isiFRSFactory->dapatkanTotalSKSDiambil($nim, $ta);
		// BUG: ada bug nomor #13
		// jangan lupa untuk mengambil kelas yang saat ini mau diambil namun belum di 
		// simpan di db
		$sksMauDiambil = $pengampuKelas->mataKuliah->sks;
		// update total sks
		$totalSKS += $sksMauDiambil;
		if($totalSKS >= 25) {
            $validator->getMessageBag()->add('kelas_bisa_diambil', 'Tidak benar nilai SKS nya');
            return false;
        }

        return true;
    }
}