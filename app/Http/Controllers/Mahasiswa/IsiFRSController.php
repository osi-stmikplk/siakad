<?php
/**
 * Pengisian FRS
 * Pada bagian tampilan akan menampilkan proses pengisian di mana terbagi dalam dua buah bagian utama yaitu MK Diambil
 * dan MK Tersedia. Pada prosesnya adalah:
 * - tampilkan tombol untuk memulai pengisian Rencana Studi <- apabila pada periode pengisian
 * User: toni
 * Date: 18/05/16
 * Time: 12:03
 */

namespace Stmik\Http\Controllers\Mahasiswa;


use Stmik\Factories\IsiFRSFactory;
use Stmik\Http\Controllers\Controller;

class IsiFRSController extends Controller
{
    /** @var IsiFRSFactory */
    protected $factory;

    public function __construct(IsiFRSFactory $factory)
    {
        $this->factory = $factory;
    }



}