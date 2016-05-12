<?php
/**
 * Atur untuk penampilan dan perhitungan hasil study milik mahasiswa
 * User: toni
 * Date: 12/05/16
 * Time: 16:50
 */

namespace Stmik\Factories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HasilStudyMahasiswaFactory extends MahasiswaFactory
{
    /**
     * Dapatkan data history pengambilan kuliah yang nantinya akan dijadikan sebagai dasar perhitungan untuk menghitung
     * IPK dan IPS
     * @param string $nim Nomor Induk Mahasiswa
     * @param array $pagination
     * @param Request $request
     */
    public function getBTTable($pagination, Request $request)
    {
        $filter = isset($pagination['otherQuery']['filter'])? $pagination['otherQuery']['filter']: [];
        // tahun ajaran
        $ta = isset($filter['ta'][0]) ? $filter['ta']: null;
        // semester
        $sem = isset($filter['sem'][0]) ? $filter['sem']: null;
        $builder = \DB::table('rencana_studi as rs')
            ->join('rincian_studi as ris', 'ris.rencana_studi_id', '=', 'rs.id')
            ->join('pengampu_kelas as pk', 'pk.id', '=', 'ris.kelas_diambil_id')
            ->join('mata_kuliah as mk', 'mk.id', '=', 'pk.mata_kuliah_id')
            // user ini login sebagai mahasiswa, dan username mahasiswa adalah NIM nya
            ->where('rs.mahasiswa_id', '=', \Session::get('username', 'NOTHING'));
//            ->orderBy('rs.tahun_ajaran')
//            ->orderBy('mk.semester');

        if($ta!==null) {
            $builder = $builder->where('rs.tahun_ajaran', '=', $ta);
        }
        if($sem!==null) {
            $builder = $builder->where('ris.semester', '=', $ta);
        }
        // sekarang selectnya ... harus explisit
        $builder = $builder->select(['rs.tahun_ajaran', 'mk.nama as mata_kuliah', 'mk.kode as kode_mata_kuliah',
            'ris.semester', 'mk.sks', 'ris.nilai_huruf', 'ris.nilai_angka', 'ris.status_lulus']);

        // kembalikan datanya!
        return $this->getBTData($pagination,
            $builder,
            ['tahun_ajaran', 'mata_kuliah', 'kode_mata_kuliah', 'semester', 'sks', 'nilai_huruf', 'nilai_angka', 'status_lulus'],
            ['tahun_ajaran'=>'rs.tahun_ajaran', 'mata_kuliah'=>'mk.nama', 'kode_mata_kuliah'=>'mk.kode',
                'semester'=>'ris.semester', 'sks'=>'mk.sks']);
    }

    /**
     * Lakukan proses perhitungan IPK dan IPS di sini.
     * @param string $nim Nomor Induk Mahasiswa
     * @return bool
     */
    public function hitungIPKdanIPS($nim)
    {

        return $this->errors->count() <= 0;
    }

}