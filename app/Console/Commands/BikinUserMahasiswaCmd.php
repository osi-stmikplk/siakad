<?php

namespace Stmik\Console\Commands;

use Illuminate\Console\Command;
use Stmik\Mahasiswa;
use Stmik\User;

class BikinUserMahasiswaCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siakad:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset semua user mahasiswa, bikin user dari data mahasiswa';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Setting akan dilakukan, reset akan dilaksanakan. Awas data hilang, ingat backup!');
        if(!$this->confirm('Lanjutkan?')) {
            $this->info('Dibatalkan!');
            exit();
        }
        //lanjutkan
        \DB::beginTransaction();
        try {
            $chunks = 0;
            Mahasiswa::with('user')->chunk(100, function($mahasiswa) use(&$chunks) {
                $this->info('Melakukan proses data mahasiswa bagian ke ' . (++$chunks) );
                /** @var Mahasiswa $m */
                $m = null;
                foreach($mahasiswa as $m) {
                    $user = $m->user; // ambil data user
                    if($user === null) { // belum punya user?
                        // user baru
                        $user = new User();
                        } else {
                            continue; // jangan rubah yang sudah dimasukkan!
                    }
                    // set password dengan tanggal lahir!
                    $user->password = \Hash::make($m->tgl_lahir);
                    // set nomor induk sebagai username
                    $user->name = $m->nomor_induk;
                    // email kosong dulu!
                    $user->email = $m->nomor_induk.'@mohon-ubah-saya.com';
                    $user->save();
                    // ingat ini polymorphic maka ... set ke dalam relasi milik modelEmpunyaUser
                    $m->user()->save($user);
                    // yeah untuk Role default ...?
                    $user->assignRole('mahasiswa');
                }
            });
            \DB::commit();
            $this->info('Selesai ...');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), []);
            $this->error("OH FUCK : ".$e->getMessage());
        }
    }
}
