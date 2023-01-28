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
Route::get('login', ['uses' => 'UserController@logPage'])->name('login');
Route::get('logout', ['uses' => 'UserController@logout'])->name('logout');
Route::get('home', ['uses' => 'HomeController@home'])->name('home_page');
Route::get('dashboard', ['uses' => 'HomeController@dashboard'])->name('dashboard');
Route::post('login-submit', ['uses' => 'UserController@logSubmit'])->name('user_authenticate');

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
/* add user */
    Route::get('add', ['uses' => 'UserController@create'])->name('user_add');
    Route::get('index', ['uses' => 'UserController@index'])->name('user_index');
    Route::post('store', ['uses' => 'UserController@store'])->name('user_store');
    Route::post('update/{id}', ['uses' => 'UserController@update'])->name('user_update');
    Route::get('edit/{id}', ['uses' => 'UserController@edit'])->name('user_edit');
    Route::get('delete/{id}', ['uses' => 'UserController@destroy'])->name('user_destroy');
    Route::get('view/{id}', ['uses' => 'UserController@view'])->name('user_view');

    Route::post('/user-status', ['uses' => 'UserController@updateUserStutus'])->name('user_status');

});
