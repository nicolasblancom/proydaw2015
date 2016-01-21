<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    // Calling home view
    Route::get('/',[
		'uses' => '\Socialdaw\Http\Controllers\HomeController@index',
		'as'   => 'home',
	]);

    // Testing flash messages
	Route::get('/alert', function(){
		return redirect()->route('home')->with('info','Mesaje flasheado en sesión ok! :)');
	});

	/*
	| Registro de usuarios
	*/
	// Calling registro view
	Route::get('/registro',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@getRegistro',
		'as' => 'auth.registro',
	]);

	// Calling registro view
	Route::post('/registro',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@postRegistro',
	]);

	/*
	| Login de usuarios
	*/
	// Calling login view
	Route::get('/login',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@getLogin',
		'as' => 'auth.login',
	]);

	// Calling registro view
	Route::post('/login',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@postLogin',
	]);

	// Calling login view
	Route::get('/logout',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@getLogout',
		'as' => 'auth.logout',
	]);
});
