<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function() {});

Route::post('/contact', function() {});

Route::get('/about', function() {});

Route::group(['prefix' => 'products'], function() {
    Route::get('view/{product}', function() {});

    Route::post('add-to-basket/{product}', function() {});
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('login', function() {});
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('dashboard', function() {});
});

Route::get('sitemap.xml', function() {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'application/xml');
});
