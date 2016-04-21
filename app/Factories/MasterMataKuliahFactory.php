<?php
/**
 * Atur bagaimana proses bisnisnya
 * User: toni
 * Date: 15/04/16
 * Time: 20:45
 */

namespace Stmik\Factories;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Stmik\MataKuliah;

class MasterMataKuliahFactory extends AbstractFactory
{
    protected $statusTerakhir = MataKuliah::STATUS_AKTIF;

    public static function getStatusLists()
    {
        return [
            MataKuliah::STATUS_AKTIF=>'Status Aktif',
            MataKuliah::STATUS_HAPUS=>'Status Hapus'
        ];
    }

    public function getBTTable($pagination, Request $request)
    {
        $filter = isset($pagination['otherQuery']['filter'])? $pagination['otherQuery']['filter']: [];
        $jurusan = isset($filter['jurusan'][0]) ? $filter['jurusan']: null;
        $status = isset($filter['status'][0]) ? $filter['status']: null;


        $builder = \DB::table('mata_kuliah as mk')
            ->join('jurusan as j', function($join) use($jurusan) {
                $join->on('j.id', '=', 'mk.jurusan_id');
                if($jurusan!==null) {
                    $join->where('j.id', '=', $jurusan);
                }
            })
            ->select(['mk.id', 'j.nama as nama_jurusan', 'mk.nama', 'mk.kode', 'mk.sks', 'mk.semester', 'mk.status']);

        if($status!==null) {
            $builder = $builder->where('status', $status);
        } else {
            $builder = $builder->where('status', MataKuliah::STATUS_AKTIF);
        }

        return $this->getBTData($pagination,
            $builder,
            ['mk.id', 'nama_jurusan', 'mk.nama', 'mk.kode', 'mk.sks', 'mk.semester', 'mk.status'],
            ['nama_jurusan'=>'j.nama', 'nama'=>'mk.nama', 'id'=>'mk.id', 'kode'=>'mk.kode']
        );
    }

    /**
     * Lakukan proses setting status mata kuliah, karena hanya dua maka bila nilai status_aktif saat ini akan diset
     * menjadi status_hapus demikian sebaliknya
     * @param $id
     * @param string $dstatus bila nilai ini ada maka nilai status akan di set sesuai dengan nilai ini
     * @return bool
     */
    public function setStatus($id, $dstatus=null)
    {
        try {
            \DB::transaction(function () use ($id,$dstatus) {
                $m = MataKuliah::findOrFail($id);
                if($dstatus!==null) {
                    $m->status = $dstatus;
                }else if($m->status == MataKuliah::STATUS_AKTIF) {
                    $m->status = MataKuliah::STATUS_HAPUS;
                } else {
                    $m->status = MataKuliah::STATUS_AKTIF;
                }
                $m->save();
                $this->statusTerakhir = $m->status;
            });

        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['id'=>$id]);
            $this->errors->add('sys', 'Tidak dapat melakukan setting status');
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Apabila ada proses setting status maka kembalikan nilai terakhir status mata kuliah nya ...
     * @return string
     */
    public function getStatusTerakhirDiInsert()
    {
        return $this->statusTerakhir;
    }

    /**
     * Kembalikan data mata kuliah!
     * @param $id
     * @return mixed
     */
    public function getDataMataKuliah($id)
    {
        return MataKuliah::findOrFail($id);
    }

    /**
     * Lakukan update
     * @param $id
     * @param $input
     * @return bool
     */
    public function update(MataKuliah $mataKuliah, $input)
    {
        return $this->realSave($mataKuliah, $input);
    }

    /**
     * Di sini proses sebenarnya dilakukan
     * TODO: apakah saat update ini diperbolehkan untuk update jurusan dan kode mata kuliah? Karena ini berarti propagasi ke semua kode mata kuliah yang sudah diambil. Atau gunakan saja foreign key?
     * @param MataKuliah $mataKuliah
     * @param $input
     * @return bool
     */
    protected function realSave(MataKuliah $mataKuliah, $input)
    {
        try {
            \DB::transaction(function () use ($mataKuliah, $input) {
                $mataKuliah->fill($input);
                // id dari mata kuliah adalah kode_jenjang + kode_program_studi + kode_mata_kuliah
                // kebetulan kode_jenjang + kode_program_studi = jurusan_id
                $mataKuliah->id = $input['jurusan_id'] . $input['kode'];
                $mataKuliah->save();
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['input'=>Arr::flatten($input)]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Simpan
     * @param $input
     */
    public function store($input)
    {
        return $this->realSave(new MataKuliah(), $input);
    }

    /**
     * Kembalikan data mata kuliah berdasarkan jurusan yang nanti dipergunakan untuk melakukan loading di select dll
     * @param string $jurusan kode jurusan
     * @return mixed
     */
    public static function getMataKuliahListsBerdasarkan($jurusan)
    {
        $r = MataKuliah::whereStatus(MataKuliah::STATUS_AKTIF)
            ->whereJurusanId($jurusan)
            ->orderBy('nama')->get(['id', 'nama', 'sks', 'semester']);
        $a = [];
        foreach ($r as $item) {
            $a[$item->id] = $item->nama . " (" . $item->sks . " SKS - Semester " . $item->semester .")";
        }
        return $a;
    }
}