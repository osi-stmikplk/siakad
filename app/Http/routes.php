<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//Route::auth();

Route::group(['middleware' => ['web']], function () {

    // Authentication Routes...
    $this->get('login', 'Auth\AuthSelfController@showLoginForm');
    $this->post('login', 'Auth\AuthSelfController@login');
    $this->get('logout', 'Auth\AuthSelfController@logout');

    Route::get('/', ['as' => 'home', 'uses' => 'SiteController@index']);

    // USER
    Route::get('/user/setUserUntuk/{idOrangIni}/{typeOrangNya}', ['as' => 'user.setUserUntuk', 'uses' => 'UserController@setUserUntuk']);
    Route::post('/user/setUserUntuk/{idOrangIni}/{typeOrangNya}', ['as' => 'user.postSetUserUntuk', 'uses' => 'UserController@postSetUserUntuk']);

    // SPP
    Route::get('/akma/spp/', ['as' => 'akma.spp', 'uses' => 'Akma\StatusSPPController@index']);
    Route::post('/akma/spp/setStatus/{nim}/{ta}', ['as' => 'akma.spp.setStatus', 'uses' => 'Akma\StatusSPPController@setStatus']);
    Route::get('/akma/spp/getDT', ['as' => 'akma.spp.getDT', 'uses' => 'Akma\StatusSPPController@getDataBtTable']);

    // master mahasiswa
    Route::get('/mhs/master/', ['as' => 'mhs.master', 'uses' => 'Mahasiswa\MasterController@index']);
    Route::get('/mhs/master/getDT', ['as' => 'mhs.master.getDT', 'uses' => 'Mahasiswa\MasterController@getDataBtTable']);


    // DATA DIRI Mahasiswa
    Route::get('/mhs/dataDiri/', ['as' => 'mhs.dataDiri', 'uses' => 'Mahasiswa\DataDiriController@index']);
});