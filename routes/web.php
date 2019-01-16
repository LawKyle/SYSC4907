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

Route::get('/', function () {
    return view('welcome');
})->middleware('APIToken');

Route::get('main', 'SearchController@test')->middleware('APIAuth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'SearchController@searchBar'); 
Route::get('department/{dept}', 'SearchController@searchDepartment');
Route::get('department/1/tappedProducts', 'SearchController@getTappedProducts');
Route::get('myGroceryList', 'SearchController@shoppingList');

Route::post('loginTest', 'SearchController@loginTest')->middleware('APIAuth');
