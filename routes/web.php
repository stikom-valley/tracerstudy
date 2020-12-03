<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes([
    'register' => false,
]);

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {

    Route::get('/', 'Frontend\DashboardController@index')
        ->name('dashboard');

    Route::group(['middleware' => ['role:bpa,warek-alumni']], function () {

        // * Pengguna
        Route::get('/users', 'UserController@index')
            ->name('user.index');
    });

    // * Bagian Pengelolaan Alumni
    Route::group(['middleware' => ['role:bpa']], function () {

        // * Pengguna
        Route::get('/user/create', 'UserController@create')
            ->name('user.create');
        Route::post('/user/store', 'UserController@store')
            ->name('user.store');
        Route::get('/user/{id}/edit', 'UserController@edit')
            ->name('user.edit');
        Route::post('/user/update/{id}', 'UserController@update')
            ->name('user.update');
        Route::post('/user/destroy/{id}', 'UserController@destroy')
            ->name('user.destroy');

        // * Riwayat Pekerjaan
    });
});
