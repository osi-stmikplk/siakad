<?php

namespace Stmik\Listeners;

use IlluminateAuthEventsLogin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Stmik\Dosen;
use Stmik\Factories\UserFactory;
use Stmik\Mahasiswa;
use Stmik\Pegawai;
use Stmik\User;

/**
 * Saat user baru login maka init segera session nya!
 * Class InitSessionUntukUserLogin
 * @package Stmik\Listeners
 */
class InitSessionUntukUserLogin
{
    public $userFactory;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(\Illuminate\Auth\Events\Login $event)
    {
        $user = User::find($event->user->getAuthIdentifier());
        $type = $this->userFactory->getTypeDari($user);
        \Session::set('type', $type);
        \Session::set('username', $user->name);
    }
}
