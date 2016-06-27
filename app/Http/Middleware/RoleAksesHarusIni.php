<?php

namespace Stmik\Http\Middleware;

use Closure;

/**
 * Class RoleAksesHarusIni
 * Berhubung belum tahu bagaimana caranya untuk melakukan check terhadap role secara global dan kemudian menambahkan
 * exception, maka saya rasa untuk controller lebih baik menggunakan middleware. Menggunakan cara lama, dengan cara
 * membuat middleware yang kemudian untuk fungsi tertentu di controller bisa dimasukkan ke exception agar checking tidak
 * dijalankan.
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
        $user = $request->user();
        if(!$user->hasRole('admin')) {
            if (!$user->hasRole($role)) {
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
