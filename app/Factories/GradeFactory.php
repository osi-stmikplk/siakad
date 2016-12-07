<?php
namespace Stmik\Factories;
use Illuminate\Http\Request;
use Stmik\Grade;
use Stmik\Http\Requests\GradeRequest;

/**
 * Class GradeFactory
 * @package Stmik\Factories
 */
class GradeFactory extends AbstractFactory
{

    /**
     * Render data
     * @param $pagination
     * @param Request $request
     */
    public function getBTTable($pagination, Request $request)
    {
        $builder = new Grade();
        return $this->getBTData($pagination, $builder, ['tahun_ajaran_mulai', 'tahun_ajaran_berakhir']);
    }

    /**
     * Ambil data Grade sesuai dengan $tahunAjaran yang ditetapkan!
     * @param null $tahunAjaran
     * @return mixed
     * @throws \Exception
     */
    public function dapatkandataGradePada($tahunAjaran=null)
    {

        $ta = $tahunAjaran === null ?
            ReferensiAkademikFactory::getTAAktif()->tahun_ajaran:
            $tahunAjaran;

        $cacheKey = "grade-tahun-$ta";
        $dataG = pakai_cache($cacheKey, function() use($ta) {
            return Grade::where('tahun_ajaran_mulai','<=', $ta)
                ->where('tahun_ajaran_berakhir', '>=', $ta)
                ->first();
        });

        if($dataG === null) {
            throw new \Exception('Data Grade pada tahun ajaran '. $tahunAjaran . ' tidak ditemukan!');
        }

        return $dataG;
    }

    /**
     * Dapatkan grade terhadap $nilai di $tahunAjaran yang diminta. Apabila nilai $tahunAjaran adalah null maka akan
     * diambil TA aktif.
     * @param double $nilai
     * @param string $tahunAjaran
     * @return string
     */
    public function dapatkanGrade($nilai, $tahunAjaran = null)
    {
        $g = $this->dapatkandataGradePada($tahunAjaran);

        if($g->minimal_a > -1 && $g->minimal_a <= $nilai) {
            return 'A';
        } else if($g->minimal_ab > -1 && $g->minimal_ab <= $nilai) {
            return 'AB';
        } else if($g->minimal_b > -1 && $g->minimal_b <= $nilai) {
            return 'B';
        } else if($g->minimal_bc > -1 && $g->minimal_bc <= $nilai) {
            return 'BC';
        } else if($g->minimal_c > -1 && $g->minimal_c <= $nilai) {
            return 'C';
        } else if($g->minimal_d > -1 && $g->minimal_d <= $nilai) {
            return 'D';
        }
        return 'E';
    }

    /**
     * Kembalikan nilai angka sesuai dengan $grade.
     * @param $grade
     * @param null $tahunAjaran
     * @return int
     * @throws \Exception
     */
    public function dapatkanGradeNilaiAngka($grade, $tahunAjaran = null)
    {
        $g = $this->dapatkandataGradePada($tahunAjaran);
        $a = 0;

        switch(strtoupper($grade)) {
            case 'A': $a = $g->angka_a; break;
            case 'AB': $a = $g->angka_ab; break;
            case 'B': $a = $g->angka_b; break;
            case 'BC': $a = $g->angka_bc; break;
            case 'C': $a = $g->angka_c; break;
            case 'D': $a = $g->angka_d; break;
        }
        return $a;
    }

    /**
     * Tentukan apakah grade merupakan status yang lulus?
     * @param $grade
     * @return bool
     */
    public function apakahGradeIniLulus($grade)
    {
        switch(strtoupper($grade)) {
            case 'D':
            case 'E':
                return false;
        }
        return true;
    }

    /**
     * Simpan data baru
     * @param $input
     * @return bool
     */
    public function store($input)
    {
        $g = new Grade();
        $g->fill($input);
        return $g->save();
    }

    /**
     * Update Grade
     * @param $id
     * @param $input
     * @return bool
     */
    public function update($id, $input)
    {
        /** @var Grade $g */
        $g = Grade::findOrFail($id);
        $g->fill($input);
        return $g->save();
    }

    /**
     * @param $id
     * @return Grade
     */
    public function dapatkanData($id)
    {
        return Grade::findOrFail($id);
    }

    /**
     * Hapus
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        try {
            \DB::transaction(function () use ($id) {
                Grade::findOrFail($id)->delete();
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['id'=>$id]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }
}