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

Route::get('users', 'UsersController@index');

Route::get('login', 'UsersController@login');

Route::get('api/pages/{url}','PagesController@index');

Route::get('api/pages/create/{url}', 'PagesController@create');
