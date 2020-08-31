<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

define('PAGINATION_COUNT', 10);

Route::group(['namespace' => 'Admin', 'Middleware' => 'auth:admin' ], function () {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    ////////////////////Start Languages Routes//////////////////////////
    Route::group(['prefix' => 'languages'], function () {
        Route::get('/','LanguagesController@index')->name('admin.languages');
        Route::get('create','LanguagesController@create')->name('admin.languages.create');
        Route::post('store','LanguagesController@store')->name('admin.languages.store');
        Route::get('edit/{id}','LanguagesController@edit')->name('admin.languages.edit');
        Route::post('update/{id}','LanguagesController@update')->name('admin.languages.update');
        Route::get('delete/{id}','LanguagesController@destroy')->name('admin.languages.delete');
    });
    //////////////////////End Languages Routes//////////////////////////

    ////////////////////Start Main Categories Routes//////////////////////////
    Route::group(['prefix' => 'main-categories'], function () {
        Route::get('/','MainCategoryController@index')->name('admin.maincategories');
        Route::get('create','MainCategoryController@create')->name('admin.maincategories.create');
        Route::post('store','MainCategoryController@store')->name('admin.maincategories.store');
        Route::get('edit/{id}','MainCategoryController@edit')->name('admin.maincategories.edit');
        Route::post('update/{id}','MainCategoryController@update')->name('admin.maincategories.update');
        Route::get('delete/{id}','MainCategoryController@destroy')->name('admin.maincategories.delete');
    });
    //////////////////////End Main Categories Routes///////////////////////////
});

Route::group(['namespace' => 'Admin', 'Middleware' => 'guest:admin' ], function () {
    Route::get('login', 'LoginController@getLogin')->name('get.admin.login');
    Route::post('login', 'LoginController@login')->name('admin.login');
});

