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
Route::get('/users/verify/{id}', 'Backend\RegisterController@verify')->name('users.verify');
Route::get('/users/buyer', 'Backend\RegisterController@buyer')->name('users.buyer');
Route::get('/users/seller', 'Backend\RegisterController@seller')->name('users.seller');
Route::get('/users/customer', 'Backend\RegisterController@customer')->name('users.customer');
Route::get('/users/admin', 'Backend\RegisterController@admin')->name('users.admin');
Route::get('/users/both', 'Backend\RegisterController@both')->name('users.both');
Route::get('/users/verified', 'Backend\RegisterController@verified')->name('users.verified');
Route::get('/users/unVerified', 'Backend\RegisterController@unVerified')->name('users.unVerified');
Route::resource('users','Backend\RegisterController');
Route::resource('category','Backend\CategoryController');
Route::resource('subCategory','Backend\SubCategoryController');

Route::get('detail/number/{id}', 'Backend\DetailController@number')->name('detail.number');
Route::get('detail/{use}/number/{id}', 'Backend\DetailController@numberEdit')->name('detail.numberEdit');
Route::resource('detail','Backend\DetailController');
Route::resource('classification','Backend\ClassificationController');
Route::resource('buyer','Backend\BuyerController');

Route::post('item/advance', 'Backend\SearchController@advance')->name('search.advance');
Route::resource('search','Backend\SearchController');

Route::get('item/{use}/ajax/{id}', 'Backend\ItemController@ajaxEdit')->name('item.ajaxEdit');

Route::get('item/frontShow/{id}', 'Backend\ItemController@frontShow')->name('item.frontShow');
Route::get('item/ajax/{id}', 'Backend\ItemController@ajax')->name('item.ajax');
Route::get('item/inReview', 'Backend\ItemController@inReview')->name('item.inReview');
Route::get('item/verified', 'Backend\ItemController@verified')->name('item.verified');
Route::get('item/unVerified', 'Backend\ItemController@unVerified')->name('item.unVerified');
Route::get('item/sold', 'Backend\ItemController@sold')->name('item.sold');
Route::get('item/bought', 'Backend\ItemController@bought')->name('item.bought');
Route::get('item/addDetail/{id}', 'Backend\ItemController@addDetail')->name('item.addDetail');
Route::resource('item','Backend\ItemController');
Route::resource('test','TestController');

Route::resource('slider','Frontend\SliderController');
Route::resource('commission','Backend\CommisionBidController');
Route::get('commission/bid/{id}', 'Backend\CommisionBidController@bid')->name('commission.bid');
Route::get('limit/index', 'Backend\CommisionBidController@limitIndex')->name('commission.limitIndex');
Route::get('limit/buyer/{id}', 'Backend\CommisionBidController@limit')->name('commission.limit');
Route::PUT('limit/buyer/{id}', 'Backend\CommisionBidController@updateLimit')->name('commission.updateLimit');

Route::get('auctioned/auctioneer/{id}', 'Backend\AuctionedController@auctioneer')->name('auctioned.auctioneer');
Route::resource('auctioned','Backend\AuctionedController');

Route::resource('auction','Backend\AuctionController');
Route::get('auction/theme/{id}', 'Backend\AuctionController@theme')->name('auction.theme');
Route::get('auction/ajax/{id}', 'Backend\AuctionController@ajax')->name('auction.ajax');
Route::get('auction/publish/{id}', 'Backend\AuctionController@publish')->name('auction.publish');
Route::get('auction/artists/{id}', 'Backend\AuctionController@artists')->name('auction.artists');
Route::get('auction/{use}/ajax/{id}', 'Backend\AuctionController@ajaxEdit')->name('auction.ajaxEdit');
Route::get('auction/{use}/artists/{id}', 'Backend\AuctionController@artistEdit')->name('auction.artistsEdit');
Route::get('auction/{use}/theme/{id}', 'Backend\AuctionController@themeEdit')->name('auction.themeEdit');





Route::get('/seller', function () {
    return view('frontend/seller');
})->name('seller');
Route::get('/buyers', function () {
    return view('frontend/buyer');
})->name('buyer');

