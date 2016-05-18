<?php
/**
 * Pengaturan untuk pengisian Form Rencana Study
 * User: toni
 * Date: 18/05/16
 * Time: 12:02
 */

namespace Stmik\Factories;


use Carbon\Carbon;
use Stmik\Mahasiswa;
use Stmik\ReferensiAkademik;
use Stmik\RencanaStudi;

class IsiFRSFactory extends AbstractFactory
{
    const MA_BUKAN_WAKTUNYA = -1;
    const MA_KEWAJIBAN_DULU = 0;
    const MA_MULAI_ISI = 1;
    const MA_MULAI_PILIH = 2;

    /**
     * Tentukan mode awal Mahasiswa ini, apakah dia:
     * MULAIISI         -> munculkan tomobl mulai pengisian, data rencana studi belum terbuat
     * MULAIPILIH       -> sudah terbuat rencana studi, tapi rincian belum selesai
     * KEWAJIBANDULU    -> uff, harus selesaikan dulu kewajiban
     * BUKANWAKTUNYA    -> belum saatnya mengisi KRS :D
     */
    public function tentukanModeAwal($nim = null)
    {
        $nim = $nim === null ? \Session::get("username", "NOTHING"): $nim;
        if( !ReferensiAkademikFactory::hariIniMasihBisaIsiFRS() ) {
            return self::MA_BUKAN_WAKTUNYA;
        }

        $b = RencanaStudi::whereTahunAjaran(ReferensiAkademikFactory::getTAAktif()->tahun_ajaran)
                ->whereMahasiswaId($nim);
        if( $b->count() <= 0 ) {
            return self::MA_MULAI_ISI;
        }

        return self::MA_MULAI_PILIH;
    }

    /**
     * Mulai pengisian FRS sederhananya adalah penambahan data pada RencanaStudy
     * @param string $nim NIM Mahasiswa
     * @return bool
     */
    public function mulaiPengisianFRS($nim = null)
    {
        $nim = $nim === null ? \Session::get("username", "NOTHING"): $nim;
        $ta = ReferensiAkademikFactory::getTAAktif();
        $mhs = Mahasiswa::whereNomorInduk($nim)->first();
        try {
            $rs = new RencanaStudi();
            $rs->tahun_ajaran = $ta->tahun_ajaran;
            $rs->mahasiswa_id = $nim;
            $rs->tgl_pengisian = date('d-m-Y');
            $rs->status = RencanaStudi::STATUS_DRAFT;
            $rs->semester = $mhs->dapatkanSemester($ta->tahun_ajaran);
            $rs->ips = 0;
            $rs->id = $rs->generateId(); // pastikan untuk melakukan generate id ...
            $rs->save();
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['nim'=>$nim]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }
}