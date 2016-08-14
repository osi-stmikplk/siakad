<?php

namespace Stmik\Http\Middleware;

use Closure;

/**
 * Class RequestHarusHTTPS
 * Pastikan saat mengakses ke link yang secure harus menggunakan HTTPS, di sini kita harus memastikan bahwa HTTPS sudah
 * terpasang di web servernya. Middleware akan melakukan pembacaan terhadap setting yang dimasukkan di siakad.https.
 * @package Stmik\Http\Middleware
 */
class RequestHarusHTTPS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->secure()) { // bila sudah https acuhkan
            $settingHttps = \Config::get('siakad.https'); // dapatkan config
            if(strcmp($settingHttps, 'sebagian') === 0) {
                // sebagian maka hanya digunakan untuk login, data diri
                if($request->is('login', 'user/profile', 'mhs/dataDiri')) {
                    return redirect()->secure($request->getRequestUri());
                }

            } else if(strcmp($settingHttps, 'penuh') === 0) {
                return redirect()->secure($request->getRequestUri());
            }
        }
        return $next($request);
    }
}
