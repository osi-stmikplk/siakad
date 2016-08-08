<?php
/**
 * Satu Dosen jangan sampai double mengajar MK yang sama pada kelas yang sama!
 *
 * User: toni
 * Date: 08/08/16
 * Time: 11:46
 */

namespace Stmik\Http\Validators;


use Stmik\Factories\DosenKelasMKFactory;

class DosenKelasMKValidator
{

    protected $dosenKelasMKFactory;
    public function __construct(DosenKelasMKFactory $dosenKelasMKFactory)
    {
        $this->dosenKelasMKFactory = $dosenKelasMKFactory;
    }

    /**
     * Pastikan si do'i tidak mengajar pada MK yang sama pada Tahun Ajaran yang sama pada Kelas yang sama!
     * 'kelas' => 'dosenKelasMK:tahun_ajaran,mata_kuliah_id,dosen_id'
     * @param $attribute
     * @param $value
     * @param $paramaters
     * @param $validator
     */
    public function dosenBolehAjarKelasMk($attribute, $value, $paramaters, $validator)
    {
        list($tahunAjaran, $MKId, $dosenId) = $paramaters;
        // filter!
        $daftarKelas = $this->dosenKelasMKFactory->dapatkanKelasDosenPada($tahunAjaran, $dosenId);
        // sekarang cari yang sama id untuk mkid
        $filtered = $daftarKelas->where('mata_kuliah_id', $MKId)->where('kelas', $value);
        if($filtered->count() > 0) {
            $validator->getMessageBag()->add('kelas', 'Double Kelas untuk Dosen Ini pada MK yang sama!');
            return false;
        }
        return true;
    }
}