<?php
/**
 * Mengatur proses bisnis Mahasiswa
 * User: toni
 * Date: 10/04/16
 * Time: 9:56
 */

namespace Stmik\Factories;

use Stmik\Mahasiswa;
use Stmik\User;

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

    /**
     * Dapatkan status mahasiswa yang sudah tidak kuliah
     * @return array
     */
    public static function getStatusSudahTidakKuliahLagi()
    {
        return [
            Mahasiswa::STATUS_DROP_OUT,
            Mahasiswa::STATUS_KELUAR,
            Mahasiswa::STATUS_LULUS,
            Mahasiswa::STATUS_PINDAH
        ];
    }

    /**
     * Dapatkan data diri mahasiswa, bila $nim adalah null maka gunakan user yang saat ini login.
     * @param null $nim
     * @return mixed
     */
    public function getDataMahasiswa($nim = null)
    {
        if($nim===null) {
            // kembalikan langsung saja link polymorphic nya yang pasti merupakan mahasiswa
            return \Auth::user()->owner;
        }
        // kalau di sini cari manual
        // karena id sudah diset sebagai nomor induk mahasiswa maka ...
        return Mahasiswa::findOrFail($nim);
    }

    /**
     * Kembalikan data Email Mahasiswa
     * @param null $nim bila nilai null mahasiswa yang saat itu login
     * @return mixed
     */
    public function getDataEmailMahasiswa($nim = null)
    {
        $dnim = $nim;
        if($nim===null) {
            $dnim = \Auth::user()->name;
        }
        // saat user melakukan update email, maka data yang ada di Auth::user adalah cache dari saat pertama login.
        // Hal ini menyebabkan kita harus mengambil data dari table yang telah di update sebelumnya ...
        return User::whereName($dnim)->first()->email;
    }

    /**
     * Kembalikan daftar status mahasiswa
     * @param int $value bila nilainya adalah -1 (default) maka akan mengembalikan semua daftar sebagai array
     * @return array|string
     */
    public static function getStatusLists($value=-1)
    {
        $r = [
            Mahasiswa::STATUS_AKTIF => 'Aktif',
            Mahasiswa::STATUS_CUTI => 'Cuti',
            Mahasiswa::STATUS_DROP_OUT => 'Drop Out',
            Mahasiswa::STATUS_KELUAR => 'Keluar',
            Mahasiswa::STATUS_LULUS => 'Lulus',
            Mahasiswa::STATUS_NON_AKTIF => 'Non Aktif',
            Mahasiswa::STATUS_PINDAH => 'Pindah'
        ];
        if($value===-1) return $r;
        return $r[$value];
    }

    /**
     * Kembalikan daftar status awal masuk mahasiswa
     * @param int $value
     * @return array|String
     */
    public static function getStatusAwalMasukLists($value = -1)
    {
        $r = [
            Mahasiswa::AWAL_MASUK_BARU => 'Mahasiswa Baru',
            Mahasiswa::AWAL_MASUK_PINDAH => 'Mahasiswa Pindahan'
        ];
        if($value===-1) return $r;
        return $r[$value];
    }

    /**
     * Fungsi untuk mendapatkan Nomor Induk Mahasiswa. Bila nilai param $nim adalah NULL maka diambil dari session dan
     * dianggap bahwa yang login sekarang adalah mahasiswa.
     * @param string $nim
     */
    public static function getNIM($nim = null)
    {
        return $nim === null ? \Session::get('username', 'NOTHING'): $nim;
    }

    /**
     * Kembalikan tahun yang bisa dipilih oleh si mahasiswa yang login, dengan awal adalah tahun masuk / angkatan!
     * Di sini dibuat khusus agar tidak menampilkan semua tahun ajaran.
     * @return array
     */
    public static function daftarTahunAjaranDapatDipilih($nim = null)
    {
        $u = (int) ($nim === null?
            \Auth::user()->owner->tahun_masuk:
            Mahasiswa::whereNomorInduk($nim)->first()->tahun_masuk);
        $yn = (int) date('Y');
        $r = [];
        for($i=$u;$i<=$yn;$i++) {
            $r["{$i}1"] = "{$i}1";
            $r["{$i}2"] = "{$i}2";
        }
        return $r;
    }

}