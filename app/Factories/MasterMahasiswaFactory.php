<?php
/**
 * Ini untuk master mahasiswa
 * User: toni
 * Date: 11/04/16
 * Time: 12:55
 */

namespace Stmik\Factories;


use Illuminate\Http\Request;

class MasterMahasiswaFactory extends MahasiswaFactory
{

    /**
     * Kembalikan nilai untuk di load di bootstrap table
     * @param $pagination
     * @param Request $request
     * @return string
     */
    public function getBTTable($pagination, Request $request)
    {
        // proses filter
        $filter = isset($pagination['otherQuery']['filter'])? $pagination['otherQuery']['filter']: [];
        $jurusan = isset($filter['jurusan'][0]) ? $filter['jurusan']: null;
        $builder = \DB::table('mahasiswa as m')
            ->join('jurusan as j', function($join) use($jurusan){
                $join->on('m.jurusan_id', '=', 'j.id');
                if($jurusan!==null) {
                    $join->where('j.id', '=', $jurusan);
                }
            })
            ->whereNotIn('m.status', $this->getStatusSudahTidakKuliahLagi())
            ->select(['m.nama', 'm.nomor_induk', 'm.jenis_kelamin', 'm.tahun_masuk', 'm.hp', 'm.status']);
        return $this->getBTData($pagination,
            $builder,
            ['nomor_induk', 'nama', 'tahun_masuk', 'jenis_kelamin', 'm.status'],
            ['nama'=>'m.nama']  // karena ada yang double untuk nama maka mapping ke m.nama (mahasiswa)
        );
    }

}