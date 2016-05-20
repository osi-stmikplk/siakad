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
    Route::delete('/akma/dkmk/delete/{id}', ['as' => 'akma.dkmk.delete', 'uses' => 'Akma\DosenKelasMKController@delete']);

    // master mahasiswa
    Route::get('/master/mahasiswa/', ['as' => 'master.mahasiswa', 'uses' => 'Master\MahasiswaController@index']);
    Route::get('/master/mahasiswa/getDT', ['as' => 'master.mahasiswa.getDT', 'uses' => 'Master\MahasiswaController@getDataBtTable']);
    Route::get('/master/mahasiswa/create', ['as' => 'master.mahasiswa.create', 'uses' => 'Master\MahasiswaController@create']);
    Route::post('/master/mahasiswa/store', ['as' => 'master.mahasiswa.store', 'uses' => 'Master\MahasiswaController@store']);
    Route::get('/master/mahasiswa/edit/{nim}', ['as' => 'master.mahasiswa.edit', 'uses' => 'Master\MahasiswaController@edit']);
    Route::post('/master/mahasiswa/update/{nim}', ['as' => 'master.mahasiswa.update', 'uses' => 'Master\MahasiswaController@update']);
    Route::delete('/master/mahasiswa/delete/{nim}', ['as' => 'master.mahasiswa.delete', 'uses' => 'Master\MahasiswaController@delete']);

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

    // Hasil Study
    Route::get('/mhs/hasilStudy/', ['as' => 'mhs.hasilStudy', 'uses' => 'Mahasiswa\HasilStudyController@index']);
    Route::get('/mhs/hasilStudy/ips/{nim?}', ['as' => 'mhs.hasilStudy.ips', 'uses' => 'Mahasiswa\HasilStudyController@ips']);
    Route::get('/mhs/hasilStudy/ipk/{nim?}', ['as' => 'mhs.hasilStudy.ipk', 'uses' => 'Mahasiswa\HasilStudyController@ipk']);
    Route::get('/mhs/hasilStudy/getDT', ['as' => 'mhs.hasilStudy.getDT', 'uses' => 'Mahasiswa\HasilStudyController@getDataBtTable']);

    // isi FRS
    Route::get('/mhs/frs/', ['as' => 'mhs.frs', 'uses' => 'Mahasiswa\IsiFRSController@index']);
    Route::post('/mhs/frs/mulai', ['as' => 'mhs.frs.mulai', 'uses' => 'Mahasiswa\IsiFRSController@mulaiPengisianFRS']);
    Route::post('/mhs/frs/pilihKelasIni/{kodeKelas}', ['as' => 'mhs.frs.pilihKelasIni', 'uses' => 'Mahasiswa\IsiFRSController@pilihKelasIni']);
    Route::post('/mhs/frs/batalkanPemilihanKelasIni/{kodeKelas}', ['as' => 'mhs.frs.batalkanPemilihanKelasIni', 'uses' => 'Mahasiswa\IsiFRSController@batalkanPemilihanKelasIni']);
    Route::get('/mhs/frs/getDT', ['as' => 'mhs.frs.getDT', 'uses' => 'Mahasiswa\IsiFRSController@getDataBtTable']);
});