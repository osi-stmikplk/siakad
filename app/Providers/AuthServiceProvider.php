<?php

namespace Stmik\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Stmik\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'Stmik\Model' => 'Stmik\Policies\ModelPolicy',
        \Stmik\Mahasiswa::class => \Stmik\Policies\MahasiswaPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $this->defineRoleUtama($gate);
    }

    protected function defineRoleUtama(GateContract $gate)
    {
        $gate->before(function(User $user, $ability) {
            if($ability != 'dataIniHanyaBisaDipakaiOleh' && $user->hasRole('admin')) {
                return true;
            }
            return false;
        });
        // digunakan untuk mencheck role, misalnya untuk akses harus role mahasiswa maka dipanggil
        // \Gate::authorize('mengaksesIniRolenyaHarus', 'mahasiswa')
        // perhatikan untuk User akan otomatis di auto load oleh laravel
        $gate->define('mengaksesIniRolenyaHarus', function(User $user, $role){
            return $user->hasRole($role);
        });

        // ada kalanya data hanya bisa digunakan oleh login milik role tertentu, misalnya data mahasiswa hanya bisa
        // diakses oleh yang role mahasiswa, maka gunakan ini. Walaupun admin yang login tetap tidak akan bisa mengakses
        // agar tidak error ...
        $gate->define('dataIniHanyaBisaDipakaiOleh', function(User $user, $role){
            return $user->hasRole($role);
        });

    }
}
