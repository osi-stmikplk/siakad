<?php

namespace Stmik\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Stmik\Mahasiswa;
use Stmik\User;

class MahasiswaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Perhatikan bahwa yang bisa melakukan update terhadap data diri adalah si mahasiswa sendiri!
     * @param User $user
     * @param Mahasiswa $mahasiswa
     * @return bool
     */
    public function postDataDiri(User $user, Mahasiswa $mahasiswa)
    {
        return $user->name === $mahasiswa->nomor_induk;
    }
}
