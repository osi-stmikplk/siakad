<?php
/**
 * Mengatur proses bisnis Mahasiswa
 * User: toni
 * Date: 10/04/16
 * Time: 9:56
 */

namespace Stmik\Factories;

use Stmik\Mahasiswa;

class MahasiswaFactory extends AbstractFactory
{

    /**
     * Dapatkan daftar status mahasiswa yang boleh membayar SPP
     * @return array
     */
    public function getStatusYangBolehBayarSPP()
    {
        return [
            Mahasiswa::STATUS_AKTIF,
            Mahasiswa::STATUS_CUTI,
            Mahasiswa::STATUS_NON_AKTIF
        ];
    }

    /**
     * Dapatkan daftar status mahasiswa yang boleh mengisi KRS
     * @return array
     */
    public function getStatusYangBolehIsiKRS()
    {
        return [
            Mahasiswa::STATUS_AKTIF,
            Mahasiswa::STATUS_NON_AKTIF
        ];
    }

}