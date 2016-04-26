<?php
/**
 * Untuk routes aplikasi
 * User: toni
 * Date: 19/11/15
 * Time: 9:01
 */

Route::get('todos', function() {
    return view('panatau-todos::todo01.index3');
});

Route::get('todos/getTodos', ['as' => 'todos/getTodos', 'uses' => 'TodosController@getTodos']);
Route::post('todos/postStore', ['as' => 'todos/postStore', 'uses' => 'TodosController@postStore']);
Route::post('todos/postUpdate/{id}', ['as' => 'todos/postUpdate', 'uses' => 'TodosController@postUpdate']);
Route::post('todos/postSetStatus/{id}/{status}', ['as' => 'todos/postSetStatus', 'uses' => 'TodosController@postSetStatus']);
