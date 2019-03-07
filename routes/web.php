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
Route::get('/newUser', 'APILoginController@registerPage');
Route::post('/addNewUser', 'APILoginController@register');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/search', 'ProductController@searchBar');
Route::get('department/{dept}', 'ProductController@searchDepartment')->name('department');
Route::get('tappedProducts', 'ProductController@getTappedProducts')->name('tappedProducts');
Route::get('product/{id}', 'ProductController@getProduct');
Route::post('editProduct', 'ProductController@editProduct');
Route::post('/checkFlagged', 'ProductController@checkFlagged');

Route::get('/myGroceryList', 'GroceryListController@shoppingList')->name("myGroceryList");
Route::get('/myGroceryList/newList', 'GroceryListController@addNewList');
Route::get('/myGroceryList/deleteList/{list_id}', 'GroceryListController@deleteList');
Route::post('/myGroceryList/editName', 'GroceryListController@editName');
Route::post('/myGroceryList/addProduct', 'GroceryListController@addProduct');
Route::post('/myGroceryList/rmProduct', 'GroceryListController@rmProduct');
Route::post('/myGroceryList/deleteProduct', 'GroceryListController@deleteProduct');

Route::get('/myProfile', 'ProfileController@profile')->name('profile');
Route::post('/myProfile/addRestriction', 'ProfileController@addRestriction');
Route::post('/myProfile/rmRestriction', 'ProfileController@rmRestriction');
Route::post('/myProfile/addRestrictions', 'ProfileController@addRestrictions');
Route::get('/myProfile/rmRestrictions/{ingredient}', 'ProfileController@rmRestrictions');

