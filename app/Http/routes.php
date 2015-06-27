<?php
use App\Page;
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

Route::get('/pages/{id}','PagesController@show');

Route::get('/pages/{id}/calculate', 'PagesController@calculate');

Route::get('/pages/destroy/{id}','PagesController@destroy');

Route::post('/pages/create', function () {
  $url   = Request::input('url');
  $dbPage = Page::whereIN('url', array($url))->get()->toArray();
  
    if($dbPage === []){
      $p = new Page;
      $p->url = $url;
      $p->save();
      return  Response::json("New Page Created");
    }
    else{
      return Response::json("Page Already Exists");
    }
  });
