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

// Route::get('/index', function () {
//     return view('index');
// });

Auth::routes(['verify' => true]);

Route::get('/home', 'IndexController@index')->name('home');
Route::get('/', 'IndexController@index')->name('home');
Route::get('/index', 'IndexController@index')->name('index');

// 3.• Page de modification de Profil.



//CRUD===========================================================================

//CREATE
Route::get('user-register', 'UserController@registerUser')->name('users.register');
Route::get('user-register/create', 'UserController@create')->name('users.create');

//READ

//UPDATE
//Les deux marchent--------------------------------------------------
// Route::get('edit-page/',  [
//     'as' => 'users.edit',
//     'uses' => 'UserController@edit'
// ])->middleware('verified');
Route::get('edit-page', 'UserController@edit')->name('users.edit')->middleware('verified');
//--------------------------------------------------------------------
// Route::get('edit',  [
//     'as' => 'users.edit',
//     'uses' => 'UserController@edit'
// ])->middleware('verified');


//Modifier les données de l'utilisateur
Route::patch('users/{user}/update',  [
    'as' => 'users.update',
    'uses' => 'UserController@update'
]);

//DELETE
Route::patch('users-edit/delete',  [
    'as' => 'users.delete',
    'uses' => 'UserController@delete'
]);
//===============================================================================
