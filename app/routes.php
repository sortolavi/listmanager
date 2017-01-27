<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::controller('/', 'TodoController');



// or with todo- and usercontrollers:
// Route::get('/', array('as'=>'todo_index', 'uses'=>'TodoController@getIndex'));
// Route::post('/add', array('as'=>'todo_add', 'uses'=>'TodoController@postAdd'));

// Route::get('/login', array('as' => 'login',   'uses' => 'UserController@getLogin'));
// Route::post('/login', array('as' => 'loginpost',  'uses' => 'UserController@postLogin'));
// Route::get('/logout', array('as' => 'logout', 'uses' => 'UserController@getLogout'));

