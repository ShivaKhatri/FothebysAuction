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

Route::get('/', 'welcomeController@index')->name('welcome');

Route::get('/redirect', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');
Route::get('/users/pending', 'Backend\RegisterController@pending')->name('users.pending');
Route::get('/users/verified', 'Backend\RegisterController@verified')->name('users.verified');
Route::get('/users/unVerified', 'Backend\RegisterController@unVerified')->name('users.unVerified');
Route::resource('users','Backend\RegisterController');
Route::resource('category','Backend\CategoryController');
Route::resource('detail','Backend\DetailController');
Route::resource('detailValue','Backend\DetailValueController');
Route::resource('classification','Backend\ClassificationController');
Route::resource('buyer','Backend\BuyerController');

Route::get('item/ajax/{id}', 'Backend\ItemController@ajax')->name('item.ajax');
Route::resource('item','Backend\ItemController');

Route::get('/seller', function () {
    return view('frontend/seller');
})->name('seller');
Route::get('/buyers', function () {
    return view('frontend/buyer');
})->name('buyer');

