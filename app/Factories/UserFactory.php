<?php
/**
 * Untuk mengatur user
 * User: toni
 * Date: 11/04/16
 * Time: 12:27
 */

namespace Stmik\Factories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Stmik\Dosen;
use Stmik\Events\PembuatanUserBaruBerhasil;
use Stmik\Mahasiswa;
use Stmik\Pegawai;
use Stmik\User;

class UserFactory extends AbstractFactory
{

    /**
     * Untuk user ini ada 3 tipe: Dosen, Mahasiswa dan Pegawai
     * @param string $type yaitu dosen|mahasiswa|pegawai
     * @return null|Dosen|Mahasiswa|Pegawai
     */
    public function getModelDari($type, $id)
    {
        switch(strtolower($type)) {
            case 'dosen': return Dosen::with('user')->findOrFail($id); break;
            case 'mahasiswa': return Mahasiswa::with('user')->findOrFail($id); break;
            case 'pegawai': return Pegawai::with('user')->findOrFail($id); break;
        }
        return null;
    }

    /**
     * Kembalikan tipe dari user
     * @param User $user
     * @return string
     */
    public function getTypeDari(User $user)
    {
        $type = 'pegawai';
        if($user->owner instanceof Mahasiswa) {
            $type = 'mahasiswa';
        } elseif($user->owner instanceof Dosen) {
            $type = 'dosen';
        }
        return $type;
    }

    /**
     * Lakukan penyimpanan terhadap user ini
     * @param Model $modelEmpunyaUser
     * @param $input
     * @return bool
     */
    public function setUserIni(Model $modelEmpunyaUser, $input)
    {
        $user = $modelEmpunyaUser->user; // ambil user, karena ini modal yang bisa punya user
        try {
            \DB::transaction(function () use ($user, $modelEmpunyaUser, $input) {
                $userbaru = false;
                if($user === null) {
                    // user baru
                    $user = new User();
                    $userbaru = true;
                }
                if(isset($input['password'][0])) {
                    // ada di set password
                    $user->password = \Hash::make($input['password']);
                }
                $user->name = $input['name'];
                $user->email = $input['email'];
                if($user->save()) {
                    if($userbaru) {
                        \Event::fire(new PembuatanUserBaruBerhasil($user));
                    }
                }
                // ingat ini polymorphic maka ... set ke dalam relasi milik modelEmpunyaUser
                $modelEmpunyaUser->user()->save($user);
                // yeah untuk Role default ...?
                $user->assignRole($this->getTypeDari($user));
            });
        } catch (\Exception $e) {
            \Log::alert("Bad Happen:" . $e->getMessage() . "\n" . $e->getTraceAsString(), ['input'=>Arr::flatten($input)]);
            $this->errors->add('system', $e->getMessage());
        }
        return $this->errors->count() <= 0;
    }

    /**
     * Update profile user
     * @param User $user
     * @param $input
     * @return bool
     */
    public function updateUser(User $user, $input)
    {
        $user->email = $input['email'];
        if(isset($input['password'])) {
            $user->password = \Hash::make($input['password']);
        }
        return $user->save();
    }

}