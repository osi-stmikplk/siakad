<?php
/**
 * Pada data yang ada saat ini, ada pada beberapa bagian setelah proses perubahan kurikulum terdapat MK yang sama namun
 * dengan kode MK yang berbeda. Sehingga dibutuhkan filtering agar MK yang double ini tidak tampil dan hanya tampil yang
 * benar saja sehingga tidak mempengaruhi hasil IPK di transkrip nilai. Issue #29
 * User: toni
 * Date: 10/08/16
 * Time: 11:50
 */

namespace Stmik\Factories;


use Stmik\RincianStudi;

class FilterMKDoubleFactory extends AbstractFactory
{
    protected $last_status = 0;

    /**
     * Set status untuk tampil_di_transkrip!
     * @param $idRincianStudi
     * @return bool
     */
    public function setStatus($idRincianStudi)
    {
        try {
            /** @var RincianStudi $rs */
            $rs = RincianStudi::findOrFail($idRincianStudi);
            if($rs->tampil_di_transkrip == RincianStudi::STATUS_TAMPIL_DI_TRANSKRIP_TDK) {
                $rs->tampil_di_transkrip = RincianStudi::STATUS_TAMPIL_DI_TRANSKRIP_YA;
            } else {
                $rs->tampil_di_transkrip = RincianStudi::STATUS_TAMPIL_DI_TRANSKRIP_TDK;
            }
            $rs->save();
            $this->last_status = $rs->tampil_di_transkrip;
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['idRincianStudi'=>$idRincianStudi]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Kembalikan status terakhir dari tampil_di_transkrip
     * @return int
     */
    public function getLastRincianStudiStatus()
    {
        return $this->last_status;
    }
}