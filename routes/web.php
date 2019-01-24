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
});

Route::post('loginTest', 'APILoginController@login')->middleware('APIAuth');
Route::get('/logout', 'APILoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'ProductController@searchBar');
Route::get('department/{dept}', 'ProductController@searchDepartment');
Route::get('tappedProducts', 'ProductController@getTappedProducts');
Route::get('product/{id}', 'ProductController@getProduct');
Route::post('editProduct', 'ProductController@editProduct');

Route::get('myGroceryList', 'GroceryListController@shoppingList');
Route::get('list/{id}', 'GroceryListController@getList');

Route::get('/myProfile', 'ProfileController@profile');
