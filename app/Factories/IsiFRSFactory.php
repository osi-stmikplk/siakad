<?php
/**
 * Pengaturan untuk pengisian Form Rencana Study
 * User: toni
 * Date: 18/05/16
 * Time: 12:02
 */

namespace Stmik\Factories;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Stmik\Mahasiswa;
use Stmik\PengampuKelas;
use Stmik\ReferensiAkademik;
use Stmik\RencanaStudi;
use Stmik\RincianStudi;
use Stmik\StatusSPP;

class IsiFRSFactory extends AbstractFactory
{
    const MA_BUKAN_WAKTUNYA = -1;
    const MA_KEWAJIBAN_DULU = 0;
    const MA_MULAI_ISI = 1;
    const MA_MULAI_PILIH = 2;
    const MA_SUDAH_TDK_KULIAH = 3;
    const MA_SUDAH_FINAL = 4; // FRS sudah disetujui!

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
        // check bila mahasiswa ini sudah lulus?
        $mhs = Mahasiswa::whereNomorInduk($nim)->first();
        if(array_search($mhs->status, MahasiswaFactory::getStatusSudahTidakKuliahLagi()) !== false) {
            return self::MA_SUDAH_TDK_KULIAH;
        }

        if( !ReferensiAkademikFactory::hariIniMasihBisaIsiFRS() ) {
            return self::MA_BUKAN_WAKTUNYA;
        }

        // check tahun ajaran
        $tahun_ajaran = ReferensiAkademikFactory::getTAAktif()->tahun_ajaran;

        // check bila sudah melakukan pembayaran SPP?
        if( StatusSPP::whereMahasiswaId($nim)->whereTahunAjaran($tahun_ajaran)
            ->whereStatus(StatusSPP::STATUS_SUDAH_BAYAR)->first() === null) {
            return self::MA_KEWAJIBAN_DULU;
        }

        // sekarang sudah mulai pengisian ...
        $b = RencanaStudi::whereTahunAjaran($tahun_ajaran)
                ->whereMahasiswaId($nim);
        if( $b->count() <= 0 ) {
            return self::MA_MULAI_ISI;
        }

        // jangan izinkan proses lagi bila FRS sudah disetujui!
        if($b->first()->status == RencanaStudi::STATUS_DISETUJUI) {
            return self::MA_SUDAH_FINAL;
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

    /**
     * Lakukan penampilan grid pilihan
     * @param $pagination
     * @param Request $request
     */
    public function getBTTable($pagination, Request $request)
    {
        $filter = isset($pagination['otherQuery']['filter'])? $pagination['otherQuery']['filter']: [];
        // TA Aktif?
        $ta = ReferensiAkademikFactory::getTAAktif();
        $nim = \Session::get("username", "NOTHING");
        $jurusan = \Auth::user()->owner->jurusan_id;
        // apa yang ditampilkan di sini?
        $tampil = (int)isset($filter['tampil'][0]) ? $filter['tampil']: null;

        $leftJoinTable = <<<SQL
    SELECT
      rs.tahun_ajaran,
      ris.kelas_diambil_id
    FROM rencana_studi as rs
    JOIN rincian_studi as ris on ris.rencana_studi_id = rs.id
    WHERE rs.mahasiswa_id = ? and rs.tahun_ajaran = ?
SQL;
        // tambahkan nama table
        $leftJoinTable = "($leftJoinTable) mdm";
        $builder = \DB::table('pengampu_kelas as pk')
            ->join('mata_kuliah as mk', 'mk.id' , '=', 'pk.mata_kuliah_id')
            ->leftJoin(\DB::raw($leftJoinTable), function($join) {
                $join->on('mdm.tahun_ajaran', '=', 'pk.tahun_ajaran')
                    ->on('mdm.kelas_diambil_id', '=', 'pk.id');
            })
            ->setBindings([$nim, $ta->tahun_ajaran])
            ->where('mk.jurusan_id', '=', $jurusan)
            ->where('pk.tahun_ajaran', '=', $ta->tahun_ajaran)
            ->where('pk.kelas', '<>', '-')
            ->orderByRaw('mk.semester');

        $builder = $builder
            ->selectRaw('pk.id,mk.semester, mk.kode, mk.nama, pk.quota, pk.jumlah_peminat, pk.jumlah_pengambil, mk.sks, pk.kelas,
  case WHEN mdm.kelas_diambil_id IS NULL THEN 0 ELSE 1 END as terpilih');

        // yang mana yang tampil?
        if($tampil!==null) {
            if($tampil==0) { // MK yang terpilih
                $builder = $builder->whereRaw('NOT mdm.kelas_diambil_id IS NULL');
            } elseif($tampil==1) { // hanya MK yang belum terpilih
                $builder = $builder->whereRaw('mdm.kelas_diambil_id IS NULL');
            }
        }

        return $this->getBTData($pagination,
            $builder,
            ['semester', 'kode', 'nama', 'kelas']);
    }

    /**
     * Lakukan proses pemilihan kelas, tambahkan kodeKelas yang diambil ke dalam rincian_study
     * @param string $kodeKelas
     * @param array $input
     */
    public function pilihKelasIni($kodeKelas, $nim = null)
    {
        $nim = $nim === null ? \Session::get("username", "NOTHING"): $nim;
        try {
            \DB::transaction(function () use ($kodeKelas, $nim) {
                $ta = ReferensiAkademikFactory::getTAAktif();
                // dapatkan rencana studi yang sudah pasti terbuat untuk tahun ajaran aktif ini!
                $rs = RencanaStudi::whereTahunAjaran($ta->tahun_ajaran)->whereMahasiswaId($nim)->first();
                // lakukan proses pembuatan rincian study
                $ris = new RincianStudi();
                $ris->kelas_diambil_id = $kodeKelas;
                $ris->semester = $rs->semester; // utk kemudahan report jer :D
                // default nilai adalah E
                $ris->nilai_huruf = 'E';
                $ris->nilai_angka = 0;
                $ris->id = $ris->kalkulasiPK($kodeKelas, $nim);
                $rs->rincianStudi()->save($ris); // simpan sebagai relasinya!
                // sekarang update pada jumlah peminat
                DosenKelasMKFactory::tambahPeminatKelasIni($kodeKelas);
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['kodeKelas'=>$kodeKelas]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Batalkan pemilihan yang dilakukan pada kelas ini
     * @param $kodeKelas
     * @return bool
     */
    public function batalkanPemilihanKelasIni($kodeKelas, $nim = null)
    {
        $nim = $nim === null ? \Session::get("username", "NOTHING"): $nim;
        try {
            \DB::transaction(function () use ($kodeKelas, $nim) {
                $ta = ReferensiAkademikFactory::getTAAktif();
                // ambil rincian studi terlebih dahulu karena di sini ada nim
                $rs = RencanaStudi::whereTahunAjaran($ta->tahun_ajaran)->whereMahasiswaId($nim)->first();
                // lalu lakukan penghapusan berdasarkan kodeKelas ...
                $rs->rincianStudi()->whereKelasDiambilId($kodeKelas)->delete();
                // update peminat dengan mengurangi jumlahnya
                DosenKelasMKFactory::kurangiPeminatKelasIni($kodeKelas);
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['kodeKelas'=>$kodeKelas]);
            $this->errors->add('sys', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Dapatkan rincian studi milik mahasiswa ini!
     * @param $nim
     * @param $ta
     * @return array
     */
    public function dapatkanRincianStudi($nim, $ta)
    {
        return \DB::table('rincian_studi as ris')
            ->join('rencana_studi as rs', function($join) use($nim, $ta) {
                $join->on('rs.id', '=', 'ris.rencana_studi_id');
                $join->where('rs.tahun_ajaran', '=', $ta);
                $join->where('rs.mahasiswa_id', '=', $nim);
            })
            ->join('pengampu_kelas as pk', 'pk.id', '=', 'ris.kelas_diambil_id')
            ->join('mata_kuliah as mk', 'mk.id', '=', 'pk.mata_kuliah_id')
            ->select(['mk.kode as kode_mk', 'mk.nama as nama_mk', 'mk.sks', 'pk.kelas'])
            ->get();
    }

    /**
     * Dapatkan total SKS diambil oleh Mahasiswa ini pada tahun ajaran yang dipilih.
     * @param $nim
     * @param $ta
     * @return float|int
     */
    public function dapatkanTotalSKSDiambil($nim, $ta)
    {
        return \DB::table('rincian_studi as ris')
            ->join('rencana_studi as rs', function($join) use($nim, $ta) {
                $join->on('rs.id', '=', 'ris.rencana_studi_id');
                $join->where('rs.tahun_ajaran', '=', $ta);
                $join->where('rs.mahasiswa_id', '=', $nim);
            })
            ->join('pengampu_kelas as pk', 'pk.id', '=', 'ris.kelas_diambil_id')
            ->join('mata_kuliah as mk', 'mk.id', '=', 'pk.mata_kuliah_id')
            ->groupBy('rs.tahun_ajaran')
            ->sum('mk.sks');
    }

    /**
     * Dapatkan IP Sementara dari semester sebelumnya. Bila $ta tidak diisi maka nilai akan diambil dari Tahun Ajaran
     * aktif.
     * @param string $nim
     * @param null $ta
     * @return int
     */
    public function dapatkanIPSSemesterSebelumnya($nim, $ta = null)
    {
        $ta = ($ta === null? ReferensiAkademikFactory::getTAAktif()->tahun_ajaran: $ta);
        $mhs = Mahasiswa::whereNomorInduk($nim)->first();
        $ipsnya = 3;
        // dapatkan semester
        $tahunIni = (int) substr($ta, 0, 4);
        $gangen = (int) substr($ta, 4);
        $sem = ($tahunIni - $mhs->tahun_masuk) * 2 + $gangen;
        // yang dicari adalah semester sebelumnya maka mundurkan satu semester
        $sem -= 1;
        // bila mahasiswa baru dan baru mengisi maka anggap bisa mengambil semua!
        if($sem <= 0) {
            return $ipsnya; // bisa mengambil 22 sks = paket
        }
        $hasilStudi = new HasilStudyMahasiswaFactory();
        $ips = $hasilStudi->loadDataPerhitunganIPS($nim);
        foreach ($ips as $ip) {
            if($ip->semester == $sem) {
                $ipsnya = $ip->jumBobotSKS / $ip->jumSKS;
                break;
            }
        }
        return $ipsnya;
    }

    /**
     * Kembalikan maksimal SKS yang bisa diambil berdasarkan IPS. Nilai yang dikembalikan di sini adalah maksimal SKS.
     * @param $nim
     * @param $ta
     * @return int
     */
    public function maksimalSKSBerdasarkanIPS($nim, $ta)
    {
        $maxSKS = 25;
        $ipsSebelumnya = $this->dapatkanIPSSemesterSebelumnya($nim, $ta);
        if($ipsSebelumnya <= 1.99) {
            $maxSKS = 17;
        } elseif($ipsSebelumnya <= 2.49) {
            $maxSKS = 19;
        } elseif($ipsSebelumnya <= 2.99) {
            $maxSKS = 21;
        } elseif($ipsSebelumnya <= 3.49) {
            $maxSKS = 23;
        }
        return $maxSKS;
    }
}
