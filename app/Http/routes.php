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

    // AKMA set Dosen - MK - Kelas
    Route::get('/akma/dkmk/', ['as' => 'akma.dkmk', 'uses' => 'Akma\DosenKelasMKController@index']);
    Route::get('/akma/dkmk/create', ['as' => 'akma.dkmk.create', 'uses' => 'Akma\DosenKelasMKController@create']);
    Route::post('/akma/dkmk/store', ['as' => 'akma.dkmk.store', 'uses' => 'Akma\DosenKelasMKController@store']);
    Route::get('/akma/dkmk/edit/{id}', ['as' => 'akma.dkmk.edit', 'uses' => 'Akma\DosenKelasMKController@edit']);
    Route::post('/akma/dkmk/update/{id}', ['as' => 'akma.dkmk.update', 'uses' => 'Akma\DosenKelasMKController@update']);
    Route::get('/akma/dkmk/getDT', ['as' => 'akma.dkmk.getDT', 'uses' => 'Akma\DosenKelasMKController@getDataBtTable']);

    // master mahasiswa
    Route::get('/master/mahasiswa/', ['as' => 'master.mahasiswa', 'uses' => 'Master\MahasiswaController@index']);
    Route::get('/master/mahasiswa/getDT', ['as' => 'master.mahasiswa.getDT', 'uses' => 'Master\MahasiswaController@getDataBtTable']);

    // master mata kuliah
    Route::get('/master/mk/', ['as' => 'master.mk', 'uses' => 'Master\MataKuliahController@index']);
    Route::get('/master/mk/create', ['as' => 'master.mk.create', 'uses' => 'Master\MataKuliahController@create']);
    Route::post('/master/mk/store', ['as' => 'master.mk.store', 'uses' => 'Master\MataKuliahController@store']);
    Route::get('/master/mk/edit/{id}', ['as' => 'master.mk.edit', 'uses' => 'Master\MataKuliahController@edit']);
    Route::post('/master/mk/update/{id}', ['as' => 'master.mk.update', 'uses' => 'Master\MataKuliahController@update']);
    Route::post('/master/mk/setStatus/{id}', ['as' => 'master.mk.setStatus', 'uses' => 'Master\MataKuliahController@setStatus']);
    Route::get('/master/mk/getDT', ['as' => 'master.mk.getDT', 'uses' => 'Master\MataKuliahController@getDataBtTable']);
    Route::post('/master/mk/loadBasedOnJurusan', ['as' => 'master.mk.loadBasedOnJurusan', 'uses' => 'Master\MataKuliahController@loadBasedOnJurusan']);

    // DATA DIRI Mahasiswa
    Route::get('/mhs/dataDiri/', ['as' => 'mhs.dataDiri', 'uses' => 'Mahasiswa\DataDiriController@index']);
    Route::post('/mhs/dataDiri/', ['as' => 'mhs.postDataDiri', 'uses' => 'Mahasiswa\DataDiriController@postDataDiri']);
});