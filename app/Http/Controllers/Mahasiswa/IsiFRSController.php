<?php
/**
 * Pengisian FRS
 * Pada bagian tampilan akan menampilkan proses pengisian di mana terbagi dalam dua buah bagian utama yaitu MK Diambil
 * dan MK Tersedia. Pada prosesnya adalah:
 * - apabila pada masa pengisian maka: tampilkan tombol untuk memulai pengisian Rencana Studi
 *   saat tombol di klik maka lakukan pembuatan rencana studi untuk mahasiswa ybs
 * - load MK yang telah dipilih pada bagian MK yang terpilih
 * - load MK yang tersedia pada bagian MK yang tersedia
 * - pada setiap pemilihan MK maka lakukan pengecekan terhadap total SKS diambil, lakukan pengecekan berapa total SKS
 *   yang boleh diambil oleh mahasiswa ini berdasarkan semester sebelumnya
 * - apabila telah lebih maka tampilkan pesan, namun tetap mahasiswa bisa memilih
 * User: toni
 * Date: 18/05/16
 * Time: 12:03
 */

namespace Stmik\Http\Controllers\Mahasiswa;


use Stmik\Factories\IsiFRSFactory;
use Stmik\Factories\ReferensiAkademikFactory;
use Stmik\Http\Controllers\Controller;

class IsiFRSController extends Controller
{
    /** @var IsiFRSFactory */
    protected $factory;

    public function __construct(IsiFRSFactory $factory)
    {
        $this->factory = $factory;

        $this->authorize('dataIniHanyaBisaDipakaiOleh', 'mahasiswa');
    }

    /**
     * Tampilkan index
     */
    public function index()
    {
        $view = 'index';
        $mode = $this->factory->tentukanModeAwal();
        if($mode == IsiFRSFactory::MA_BUKAN_WAKTUNYA) {
            $view = 'index-bukan-waktunya';
        } elseif($mode == IsiFRSFactory::MA_MULAI_ISI) {
            $view = 'index-mulai-pengisian';
        } elseif($mode == IsiFRSFactory::MA_KEWAJIBAN_DULU) {
            $view = 'index-kewajiban-dulu-coy';
        }

        return view('mahasiswa.frs.'.$view)
            ->with('infoTA', ReferensiAkademikFactory::getTAAktif())
            ->with('layout', $this->getLayout());

    }

    /**
     * Lakukan insialisasi yang dibutuhkan saat mulai melakukan pengisian FRS
     */
    public function mulaiPengisianFRS()
    {
        if($this->factory->mulaiPengisianFRS()) {
            // paksa halaman untuk melakukan refresh dengan hanya mengirimkan pesan
            return response("<h2>Tunggu beberapa saat untuk melakukan loading terhadap Form Rencana Studi</h2>");
        }
        return response(json_encode($this->factory->getErrorsString()), 500);
    }

    /**
     * Load MK yang terpilih
     */
    public function loadMKTerpilih()
    {

    }

    /**
     * Load MK yang tersedia untuk diambil. Dalam hal ini MK akan diwakili lagi oleh kelas yang menampilkan kelas,quota,
     * peminat, MK, kode MK. Di sini tidak ditampilkan nama Dosen karena tidak dibutuhkan.
     */
    public function loadMKTersedia()
    {

    }

    /**
     * Pilih $kodeKelas yang dipilih dan masukkan sebagai bagian dari MK yang diambil oleh Mahasiswa ini
     * @param $kodeKelas
     */
    public function pilihKelasIni($kodeKelas)
    {

    }

    /**
     * Batalkan pemilihan kelas dari MK yang terpilih sesuai dengan $kodeKelas
     * @param $kodeKelas
     */
    public function batalkanPemilihanKelasIni($kodeKelas)
    {

    }

    /**
     * Ajukan FRS ini sebagai final, dalam artian sudah disetujui oleh Dosen Wali. Saat FRS sudah final maka tidak dapat
     * diubah lagi oleh Mahasiswa, kecuali masuk dalam masa perubahan FRS.
     * TODO: Fasilitas ini akan dihapus pada versi selanjutnya, karena ini hanya bisa disetujui oleh Dosen Pembimbing
     */
    public function ajukanSebagaiFinal()
    {

    }

}