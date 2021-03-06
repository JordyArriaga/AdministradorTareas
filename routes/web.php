<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('NuevaTarea', 'TareasController@store')->name('NuevaTarea');
Route::delete('EliminarTarea/{id}', 'TareasController@destroy')->name('EliminarTarea');
Route::put('EmpezarTarea/{id}', 'TareasController@update')->name('EmpezarTarea');