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


use Illuminate\Http\Request;
use Stmik\Factories\DosenKelasMKFactory;
use Stmik\Factories\IsiFRSFactory;
use Stmik\Factories\MahasiswaFactory;
use Stmik\Factories\ReferensiAkademikFactory;
use Stmik\Http\Controllers\Controller;
use Stmik\Http\Controllers\GetDataBTTableTrait;
use Stmik\RencanaStudi;

class IsiFRSController extends Controller
{
    use GetDataBTTableTrait;

    /** @var IsiFRSFactory */
    protected $factory;

    public function __construct(IsiFRSFactory $factory)
    {
        $this->factory = $factory;

        $this->middleware('auth.role:mahasiswa|akma', [
            'except'=> [
                'cetakKRS'      // jangan dijalankan waktu cetak KRS, ini akan diakses oleh dosen wali,akma dll
            ]
        ]);
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
        } elseif($mode == IsiFRSFactory::MA_STATUS_DRAFT) {
            $view = 'index-status-krs-masih-draft';
        } elseif($mode == IsiFRSFactory::MA_MULAI_ISI) {
            $view = 'index-mulai-pengisian';
        } elseif($mode == IsiFRSFactory::MA_KEWAJIBAN_DULU) {
            $view = 'index-kewajiban-dulu-coy';
        } elseif($mode == IsiFRSFactory::MA_SUDAH_TDK_KULIAH) {
            $view = 'index-sudah-tdk-kuliah';
        } elseif($mode == IsiFRSFactory::MA_SUDAH_FINAL) {
            $view = 'index-frs-sudah-final';
        } elseif($mode == IsiFRSFactory::MA_STATUS_CUTI) {
            $view = 'index-status-masih-cuti';
        }

        return view('mahasiswa.frs.'.$view)
            ->with('infoTA', ReferensiAkademikFactory::getTAAktif())
            ->with('sisaHari', ReferensiAkademikFactory::dapatkanSisaHariIsiFRS())
            ->with('layout', $this->getLayout());

    }

    /**
     * Lakukan insialisasi yang dibutuhkan saat mulai melakukan pengisian FRS
     */
    public function mulaiPengisianFRS()
    {
        if($this->factory->mulaiPengisianFRS()) {
            // paksa halaman untuk melakukan refresh dengan hanya mengirimkan pesan
            return response("<h2>Tunggu beberapa saat lagi untuk melakukan loading terhadap Form Rencana Studi</h2>");
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
     * Lakukan validasi terhadap pemilihan kelas.
     * Kelas boleh dipilih bila:
     * - jumlah quota mencukupi, artinya yang mengambil masih dalam quota!
     * TODO: pastikan agar tidak terpilih mata kuliah yang sama pada satu waktu pengambilan!
     * @param $kodeKelas
     * @param bool $pembatalan beberapa validator jangan dijalankan pada saat melakukan proses pembatalan kelas!
     * @param Request $request
     */
    protected function validasiPemilihanKelas($kodeKelas, Request $request, $pembatalan=false)
    {
        $nim = MahasiswaFactory::getNIM();
        $ta = ReferensiAkademikFactory::getTAAktif()->tahun_ajaran;
        $request->merge(['kodeKelasTerpilih'=>$kodeKelas]);
        $rules = [];
        if($pembatalan) {
            $rules = [
                'kodeKelasTerpilih' => "exists:pengampu_kelas,id"
            ];
        } else {
            $rules = [
                'kodeKelasTerpilih' => "exists:pengampu_kelas,id|kelas_bisa_diambil:$nim,$ta"
            ];
        }
        $this->validate($request, $rules);
    }

    /**
     * Pilih $kodeKelas yang dipilih dan masukkan sebagai bagian dari MK yang diambil oleh Mahasiswa ini.
     * Saat terpilih pastikan untuk melakukan beberapa hal:
     * - update terhadap jumlah peminat pada kelas yang dipilih
     * - update terhadap tampilan colom aksi di User Interface
     * - update terhadap nilai peminat dan pengambil dengan yang terbaru!
     *   untuk melakukan update ini akan mengunakan response Header milik intercooler-js dengan menggunakan X-IC-Trigger
     * @param $kodeKelas
     */
    public function pilihKelasIni($kodeKelas, Request $request)
    {
        $this->validasiPemilihanKelas($kodeKelas, $request);
        if($this->factory->pilihKelasIni($kodeKelas)) {
            // dapatkan jumlah peminat dan pengambil sekarang
            $peminat = $pengambil = 0;
            DosenKelasMKFactory::dapatkanJumlahPeminatPengambilKelasIni($kodeKelas, $peminat, $pengambil);
            // kita perlu mekanisme update data untuk jumlah peminat dan pemilih kelas, jadi di sini kita gunakan
            // mekanisme yang dimiliki oleh intercoolerjs menggunakan response header X-IC-Trigger
            $triggerini['padaSetelahMemilih'] = [$kodeKelas, $peminat, $pengambil, 1];
            // karena bootstrap table akan melakukan rewrite lagi pada tampilan saat trigger dijalankan, maka pengaturan
            // tampilan dari controller ini tidak dibutuhkan lagi
            return response("",200,
                ['X-IC-Trigger' => json_encode($triggerini) ]);
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Batalkan pemilihan kelas dari MK yang terpilih sesuai dengan $kodeKelas
     * @param $kodeKelas
     */
    public function batalkanPemilihanKelasIni($kodeKelas, Request $request)
    {
        $this->validasiPemilihanKelas($kodeKelas, $request, true);
        if($this->factory->batalkanPemilihanKelasIni($kodeKelas)) {
            // dapatkan jumlah peminat dan pengambil sekarang
            $peminat = $pengambil = 0;
            DosenKelasMKFactory::dapatkanJumlahPeminatPengambilKelasIni($kodeKelas, $peminat, $pengambil);
            $triggerini['padaSetelahMemilih'] = [$kodeKelas, $peminat, $pengambil, 0];
            return response("",200,
                ['X-IC-Trigger' => json_encode($triggerini) ]);
        }
        return response(json_encode($this->factory->getErrors()), 500);
    }

    /**
     * Tampilkan KRS
     * @param null $nim
     * @param null $ta
     */
    public function cetakKRS($nim = null, $ta = null)
    {
        $mhsFactory = new MahasiswaFactory();
        $nim = $mhsFactory->getNIM($nim);
        $ta  = ($ta === null ? ReferensiAkademikFactory::getTAAktif()->tahun_ajaran : $ta);
        $mhs = $mhsFactory->getDataMahasiswa($nim);
        // lakukan pengambilan data mahasiswa
        return view('mahasiswa.frs.krs')
            ->with('ta', $ta)
            ->with('mhs', $mhs)
            ->with('maxSKS', $this->factory->maksimalSKSBerdasarkanIPS($nim, $ta))
            ->with('rincianStudi', $this->factory->dapatkanRincianStudi($nim, $ta));
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