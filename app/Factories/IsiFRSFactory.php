<?php
/**
 * Pengaturan untuk pengisian Form Rencana Study
 * User: toni
 * Date: 18/05/16
 * Time: 12:02
 */

namespace Stmik\Factories;


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

        $b = RencanaStudi::whereTahunAjaran(ReferensiAkademikFactory::getTAAktif()->id)
                ->whereMahasiswaId($nim);
        if( $b->count() <= 0 ) {
            return self::MA_MULAI_ISI;
        }

        return self::MA_MULAI_PILIH;
    }
}