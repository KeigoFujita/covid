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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('app.index');
Route::get('/fetchData', 'HomeController@fetchData')->name('app.fetchData');
Route::get('/getWorldDashboardData', 'HomeController@getDashboardData')->name('app.getDashboardData');
Route::get('/getWorldTimeline', 'HomeController@getWorldTimeline')->name('app.getWorldtimeline');
Route::get('/getCountryMetadata', 'HomeController@getCountryMetadata')->name('app.getCountryMetadata');
Route::get('/getTimeLine', 'HomeController@getTimeLine')->name('app.getTimeLine');