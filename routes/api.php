<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'API'
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => ['jwt.auth']], function () {

    Route::group(['prefix' => 'profile', 'namespace' => 'API'], function () {

        Route::get('/show', 'ProfileController@show')
            ->name('profile.show');
        Route::put('/update', 'ProfileController@updateBio')
            ->name('profile.update.bio');
        Route::post('/update/avatar', 'ProfileController@updateAvatar')
            ->name('profile.update.avatar');
        Route::put('/update/password', 'ProfileController@updatePassword')
            ->name('profile.update.password');
    });

    Route::group(['prefix' => 'experience', 'namespace' => 'API'], function () {

        Route::get('/', 'ExperienceUserController@index')
            ->name('experience.index');
        Route::post('/store', 'ExperienceUserController@store')
            ->name('experience.store');
        Route::get('/{id}/show', 'ExperienceUserController@show')
            ->name('experience.show');
        Route::put('/update/{id}', 'ExperienceUserController@update')
            ->name('experience.update');
        Route::delete('/destroy/{id}', 'ExperienceUserController@destroy')
            ->name('experience.destroy');
    });

    Route::group(['prefix' => 'skill', 'namespace' => 'API'], function () {

        Route::get('/', 'SkillUserController@index')
            ->name('skill.index');
        Route::post('/store', 'SkillUserController@store')
            ->name('skill.store');
        Route::get('/{id}/show', 'SkillUserController@show')
            ->name('skill.show');
        Route::post('/update/{id}', 'SkillUserController@update')
            ->name('skill.update');
        Route::delete('/destroy/{id}', 'SkillUserController@destroy')
            ->name('skill.destroy');
    });
});
