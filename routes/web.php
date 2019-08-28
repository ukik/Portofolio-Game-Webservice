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

Route::get('/', 'Home\HomeController@index');

Route::get('/verifikasi', 'Home\HomeController@verifikasi')->name('verification'); // untuk verifikasi admin
// Route::get('/upgrade', 'Home\HomeController@upgrade')->name('upgrade');
// Route::get('/belanja', 'Home\HomeController@belanja')->name('belanja');
// Route::get('/penarikan', 'Home\HomeController@penarikan')->name('penarikan');

Route::get('/leaderboard/{path}', 'Home\HomeController@leaderboard')->name('leaderboard');
