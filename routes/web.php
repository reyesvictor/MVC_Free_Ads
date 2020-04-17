<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/index', function () {
//     return view('index');
// });

Auth::routes(['verify' => true]);

Route::get('/home', 'IndexController@index')->name('home');
Route::get('/', 'IndexController@index')->name('home');
Route::get('/index', 'IndexController@index')->name('index');

// 3.• Page de modification de Profil.



//CRUD===========================================================================




//Les deux marchent--------------------------------------------------
// Route::get('edit-page/',  [
//     'as' => 'users.edit',
//     'uses' => 'UserController@edit'
// ])->middleware('verified');
//--------------------------------------------------------------------
// Route::get('edit',  [
//     'as' => 'users.edit',
//     'uses' => 'UserController@edit'
// ])->middleware('verified');

//Users
Route::group(['prefix' => 'user'], function () {
    //CREATE
    Route::get('register', 'UserController@registerUser')->name('users.register');
    Route::get('register/create', 'UserController@create')->name('users.create');
    //UPDATE
    Route::get('edit', 'UserController@edit')
        ->name('users.edit')
        ->middleware('verified');
    Route::post('edit',  [
        'as' => 'users.update',
        'uses' => 'UserController@update'
    ]);
    //DELETE
    Route::patch('delete',  [
        'as' => 'users.delete',
        'uses' => 'UserController@delete'
    ]);
});

Route::group(['prefix' => 'annonce'], function () {
    $name = 'annonce';
    //READ
    Route::get('show', [
        'as' => $name . '.show',
        'uses' => 'AnnonceController@show'
    ]);
    Route::get('/', [
        'as' => $name . '.index',
        'uses' => 'AnnonceController@index',
    ]);
    Route::get('{id}', [
        'as' => $name . '.getAnnonce',
        'uses' => 'AnnonceController@getAnnonce'
    ])->where('id', '[0-9]+');
    Route::get('new', [
        'as' => $name . '.new',
        'uses' => 'AnnonceController@new',
    ]);
    Route::post('new', [
        'as' => $name . '.create',
        'uses' => 'AnnonceController@create',
    ]);
    //BTN
    Route::get('edit', function() {
        return view('annonce.index');
    });
    Route::patch('edit', [
        'as' => $name . '.edit',
        'uses' => 'AnnonceController@edit',
    ]);
    Route::post('edit', [
        'as' => $name . '.update',
        'uses' => 'AnnonceController@update',
    ]);
    // Delete
    Route::post('delete', [
        'as' => $name . '.delete',
        'uses' => 'AnnonceController@destroy',
    ]);
});
