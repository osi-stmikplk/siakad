<?php

namespace Stmik\Http\Controllers\Akma;
use Stmik\Factories\PersetujuanFRSFactory;
use Stmik\Factories\ReferensiAkademikFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;

/**
 * Untuk proses persetujuan FRS yang diajukan oleh Mahasiswa.
 * - Lakukan loading untuk semua rencana studi dengan status DRAFT
 * - Siapkan link untuk melihat KRS berdasarkan rencana studi yang dipilih
 * - Siapkan link untuk melakukan approving/persetujuan pada KRS yang diajukan
 * FRS => Form Rencana Studi : Isian rencana studi
 * KRS => Kartu Rencana Studi : cetakan dari FRS dan mendapatkan persetujuan dari Dosen Wali
 * TODO: fasilitas ini juga harus ada dan bisa dilakukan dilogin milik Dosen Wali
 * User: toni
 * Date: 31/05/16
 * Time: 17:05
 */

class PersetujuanFRSController extends Controller
{
    use GetDataBTTableTrait;

    protected $factory;

    public function __construct(PersetujuanFRSFactory $persetujuanFRSFactory)
    {
        $this->factory = $persetujuanFRSFactory;

        $this->middleware('auth.role:akma');
    }

    /**
     * Tampilkan indeks
     * @return $this
     */
    public function index()
    {
        return view('akma.persetujuan-frs.index')
            ->with('TAAktif', ReferensiAkademikFactory::getTAAktif()->tahun_ajaran)
            ->with('layout', $this->getLayout());
    }

    /**
     * Lakukan reset terhadap status yang kita miliki!
     * @param $idFRS
     */
    public function postStatus($idFRS)
    {
        if($this->factory->setStatus($idFRS)) {
            // lakukan trigger pada client
            $triggerini['padaSetelahReset'] = [$idFRS, $this->factory->getLastFRSStatus()];
            return response("",200,
                ['X-IC-Trigger' => json_encode($triggerini) ]);
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

}