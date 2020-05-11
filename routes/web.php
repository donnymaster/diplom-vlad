<?php

use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', 'HomeController@index')->name('index');

Route::resource('designers', 'DesignerController');

Route::resource('orders', 'OrderController');

Route::resource('feedbacks', 'FeedbackController');

// get ajax designers - typehead
Route::get('get-designers-ajax', 'DesignerController@getDesignersAjax')->name('get-designers-ajax');
// get ajax user orders
Route::get('get-orders', 'OrderController@orderAjaxUser')->name('get-orders');

Route::group(['middleware' => 'admin', 'middleware' => 'auth'], function(){
    // get ajax admin feedback
    Route::get('get-feedback', 'FeedbackController@getFeedbackAjax')->name('get-feedback');

    Route::post('answer', 'FeedbackController@answer')->name('feedback.answer');
    // get ajax admin designers
    Route::get('get-designers', 'DesignerController@alldesigerAdmin')->name('all.designers');
    // table admin designers
    Route::get('all-designers', 'DesignerController@alldesigerAdminAjax')->name('get-designers');
    // admin all orders
    Route::get('orders-admin', 'OrderController@adminOdersShow')->name('orders.admin');
    // admin all orders ajax
    Route::get('all-orders-admin', 'OrderController@adminOdersShowAjax')->name('get.orders.admin-ajax');
    // end order
    Route::post('end-order', 'OrderController@endOrder')->name('order-end');
});

Route::group(['miidleware' => 'auth'], function(){
    Route::get('messages', 'ChatsController@fetchMessages');

    Route::post('messages', 'ChatsController@sendMessage');

    Route::post('rating-order', 'OrderController@ratingSet')->name('rating-order');
});


