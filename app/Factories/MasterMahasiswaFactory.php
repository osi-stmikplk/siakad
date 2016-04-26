<?php
/**
 * Ini untuk master mahasiswa
 * User: toni
 * Date: 11/04/16
 * Time: 12:55
 */

namespace Stmik\Factories;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Stmik\Mahasiswa;
use Stmik\MahasiswaUtkAkma;

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
        $status  = isset($filter['status'][0]) ? $filter['status']: null;
        $builder = \DB::table('mahasiswa as m')
            ->join('jurusan as j', function($join) use($jurusan){
                $join->on('m.jurusan_id', '=', 'j.id');
                if($jurusan!==null) {
                    $join->where('j.id', '=', $jurusan);
                }
            })
            ->select(['m.nama', 'm.nomor_induk', 'm.jenis_kelamin', 'm.tahun_masuk', 'm.hp', 'm.status']);
        // proses status
        if($status!==null) {
            $builder = $builder->where('m.status', $status);
        } else {
            $builder = $builder->whereNotIn('m.status', $this->getStatusSudahTidakKuliahLagi());
        }
        return $this->getBTData($pagination,
            $builder,
            ['nomor_induk', 'nama', 'tahun_masuk', 'jenis_kelamin', 'm.status'],
            ['nama'=>'m.nama']  // karena ada yang double untuk nama maka mapping ke m.nama (mahasiswa)
        );
    }

    /**
     * Update data
     * @param $nim
     * @param $input
     * @return bool
     */
    public function update($nim, $input)
    {
        return $this->realSave(
            MahasiswaUtkAkma::findOrFail($nim),
            $input
        );
    }

    /**
     * Penyimpanan realnya di sini
     * @param MahasiswaUtkAkma $model
     * @param $input
     * @return bool
     */
    protected function realSave(MahasiswaUtkAkma $model, $input)
    {
        try {
            \DB::transaction(function () use ($model, $input) {
                $model->fill($input);
                $model->save();
                $this->last_insert_id = $model->nomor_induk;
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['input'=>Arr::flatten($input)]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Buat data baru
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        return $this->realSave(new MahasiswaUtkAkma(), $input);
    }

    /**
     * Hapuskan mahasiswa ini
     * TODO: WARNING test terhadap data berelasi dengan master ini belum dilakukan :D Tambahkan fungsi utk check atau tambahkan foreign key
     * @param $nim
     * @return bool
     */
    public function delete($nim)
    {
        try {
            \DB::transaction(function () use ($nim) {
                Mahasiswa::findOrFail($nim)->delete();
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['id'=>$pk->id]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

}