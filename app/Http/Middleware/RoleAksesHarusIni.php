<?php

namespace Stmik\Http\Middleware;

use Closure;
use Stmik\User;

/**
 * Class RoleAksesHarusIni
 * Berhubung belum tahu bagaimana caranya untuk melakukan check terhadap role secara global dan kemudian menambahkan
 * exception, maka saya rasa untuk controller lebih baik menggunakan middleware. Menggunakan cara lama, dengan cara
 * membuat middleware yang kemudian untuk fungsi tertentu di controller bisa dimasukkan ke exception agar checking tidak
 * dijalankan.
 * Apabila ingin melakukan checking terhadap role yang lebih dari satu, maka pisahkan nama role dengan tandan "|"
 * Sebagai contoh untuk middleware di controller:
 *
 * $this->middleware('auth.role:akma'); // yang bisa mengakses hanya role akma
 * $this->middleware('auth.role:akma|keuangan|mahasiswa'); // berarti oke untuk role akma, keuangan dan mahasiswa
 *
 * @package Stmik\Http\Middleware
 * User Toni
 */
class RoleAksesHarusIni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        /** @var User $user */
        $user = $request->user();
        if(!$user->hasRole('admin')) {
            $roles = explode("|", $role);
            if (!$user->hasRoles($roles)) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest('login');
                }
            }
        }
        return $next($request);
    }
}
