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
Route::get('get-designers', 'DesignerController@getDesignersAjax')->name('get-designers');
// get ajax user orders
Route::get('get-orders', 'OrderController@orderAjaxUser')->name('get-orders');
// get ajax admin feedback
Route::get('get-feedback', 'FeedbackController@getFeedbackAjax')->name('get-feedback');