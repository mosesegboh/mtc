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


Route::get('/', 'HomeController@index')->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('deleteProperty', 'HomeController@deleteProperty')->name('deleteProperty');

Route::post('/addProperty', 'HomeController@addProperty')->name('addProperty');

Route::post('/search', 'HomeController@searchProperty')->name('search');

Route::post('/editProperty/{id}', 'HomeController@editProperty')->name('editProperty');

Route::post('/updateProperty/{id}', 'HomeController@updateProperty')->name('updateProperty');

Route::post('/fetchAutoComplete', 'HomeController@fetchAutoComplete')->name('fetchAutoComplete');