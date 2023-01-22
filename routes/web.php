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
Route::get('login', ['uses'=>'UserController@logPage'])->name('login');
Route::get('home', ['uses'=>'HomeController@dashboard'])->name('home_page');
Route::post('login-submit', ['uses'=>'UserController@logSubmit'])->name('user_authenticate');
Route::get('logout', ['uses'=>'Admin\LoginController@logout'])->name('logout');