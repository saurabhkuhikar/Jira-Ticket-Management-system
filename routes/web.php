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

// Route::middleware(['checkStatus'])->group(function(){
    Route::get('logout', ['uses' => 'UserController@logout'])->name('logout');
    Route::get('home', ['uses' => 'HomeController@home'])->name('home_page');
    Route::get('dashboard', ['uses' => 'HomeController@dashboard'])->name('dashboard');
    Route::post('login-submit', ['uses' => 'UserController@logSubmit'])->name('user_authenticate');
// });

Route::group(['prefix' => 'user', 'middleware' => ['auth']], function () {
/* add user */
    Route::get('add', ['uses' => 'UserController@create'])->name('user_add');
    Route::get('index', ['uses' => 'UserController@index'])->name('user_index');
    Route::post('store', ['uses' => 'UserController@store'])->name('user_store');
    Route::post('update/{id}', ['uses' => 'UserController@update'])->name('user_update');
    Route::get('edit/{id}', ['uses' => 'UserController@edit'])->name('user_edit');
    Route::get('delete/{id}', ['uses' => 'UserController@destroy'])->name('user_destroy');
    Route::get('view/{id}', ['uses' => 'UserController@show'])->name('user_view');

    Route::post('/user-status', ['uses' => 'UserController@updateUserStutus'])->name('user_status');

    // Route::post('user-search', ['uses' => 'UserController@search'])->name('user_search');

});
Route::group(['prefix' => 'ticket', 'middleware' => ['auth']], function () {
    /* add user */
        Route::get('add', ['uses' => 'TicketsController@create'])->name('ticket_add');
        Route::get('index', ['uses' => 'TicketsController@index'])->name('ticket_index');
        Route::post('store', ['uses' => 'TicketsController@store'])->name('ticket_store');
        Route::post('update/{id}', ['uses' => 'TicketsController@update'])->name('ticket_update');
        Route::get('edit/{id}', ['uses' => 'TicketsController@edit'])->name('ticket_edit');
        Route::get('delete/{id}', ['uses' => 'TicketsController@destroy'])->name('ticket_destroy');
        Route::get('view/{id}', ['uses' => 'TicketsController@view'])->name('ticket_view');    
        Route::post('ticket-status', ['uses' => 'TicketsController@changeTicketStatus'])->name('ticket_status');
        Route::get('ticket-search', ['uses' => 'TicketsController@search'])->name('ticket_search');
        
        /** */
        Route::get('assign-ticket-add/{id}', ['uses' => 'TicketsController@assignTicketAdd'])->name('assign_ticket_add');
        Route::post('assign-ticket-store/{id}', ['uses' => 'TicketsController@assignTicketStore'])->name('assign_ticket_store');
        
        Route::get('change-ticket-status/{id}', ['uses' => 'TicketsController@ticketStatus'])->name('change_ticket_status');
        Route::post('change-ticket-status', ['uses' => 'TicketsController@updateTicketStatus'])->name('update_ticket_status');
    
    });
