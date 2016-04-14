<?php
/**
 * Supaya tidak menulis ulang controller asli, extends saja yang aslinya.
 * Selain itu dalam hal ini default milik Laravel tidak mendukung untuk proses secara ajax yang akan kita gunakan
 * menggunakan Intercoolerjs
 * User: toni
 * Date: 12/04/16
 * Time: 8:27
 */

namespace Stmik\Http\Controllers\Auth;


use Illuminate\Http\Request;

class AuthSelfController extends AuthController
{
    protected $redirectTo = '/';

    /**
     * Kita ingin agar proses pencekan credentials tidak hanya dilakukan dengan dasar email, tapi juga bisa dilakukan
     * dengna menggunakan username, yang dalam hal ini bernama field name pada table users kita. Karena itu kita
     * tambahkan pada field input requests dengan field baru bernama 'name' dan nilai adalah sesuai dengan inputan
     * dari field email.
     * Override dengan cara mengubah request dengna menambahkan field untuk username, disini adalah name ...
     * @param Request $request
     */
    protected function getCredentials(Request $request)
    {
        // bila benar email yang diinputkan maka kita check berdasarkan email, bila tidak maka kita check berdasarkan name
        $field = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        // masukkan field ke request dengan nilai yang diinputkan dari email
        $request->merge([$field=>$request->input('email')]);
        return $request->only($field, 'password');
    }

    /**
     * Bila sudah benar dan telah terbukti authenticated, maka kembalikan berupa permintaan redirect ...
     * Disini nama function authenticated akan dipanggil oleh salah satu proses otentifikasi milik bawaan laravel.
     * @param Request $request
     * @param $guard
     */
    protected function authenticated(Request $request, $guard)
    {
        return \Response::make()
            ->header('X-IC-Redirect', url('/')); // di sini header X-IC-Redirect akan melakukan redirect
    }


    /**
     * Override supaya bisa menangani ajax
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if($request->ajax()) {
            return response()->json([
                $this->loginUsername()=>$this->getFailedLoginMessage()
            ], 422); // 422 adalah unprocessable entity
        }
        return parent::sendFailedLoginResponse($request);
    }
}