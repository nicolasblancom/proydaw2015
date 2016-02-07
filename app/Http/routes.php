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
		'middleware' => 'guest',
	]);

	// Calling registro view
	Route::post('/registro',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@postRegistro',
		'middleware' => 'guest',
	]);

	/*
	| Login de usuarios
	*/
	// Calling login view
	Route::get('/login',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@getLogin',
		'as' => 'auth.login',
		'middleware' => 'guest',
	]);

	// Calling registro view
	Route::post('/login',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@postLogin',
		'middleware' => 'guest',
	]);

	// Calling logout view
	Route::get('/logout',[
		'uses' => '\Socialdaw\Http\Controllers\AuthController@getLogout',
		'as' => 'auth.logout',
	]);

	/*
	| Busqueda de usuarios
	*/
	// Calling search view
	Route::get('/busqueda', [
		'uses' => '\Socialdaw\Http\Controllers\SearchController@getResultados',
		'as' => 'search.resultados',
	]);

	/*
	| Perfil de usuario
	*/
	// Calling editar perfil view
	Route::get('/usuario/edit', [
		'uses' => '\Socialdaw\Http\Controllers\ProfileController@getEdit',
		'as' => 'profile.edit',
		'middleware' => ['auth'],
	]);

	// Calling perfil view
	Route::get('/usuario/{username}', [
		'uses' => '\Socialdaw\Http\Controllers\ProfileController@getPerfil',
		'as' => 'profile.index',
	]);

	// Enviar datos de usuario editado
	Route::post('/usuario/edit', [
		'uses' => '\Socialdaw\Http\Controllers\ProfileController@postEdit',
		'middleware' => ['auth'],
	]);

	/*
	| Amigos
	*/
	// Calling amigos index view
	Route::get('/amigos', [
		'uses' => '\Socialdaw\Http\Controllers\FriendController@getIndex',
		'as' => 'friends.index',
		'middleware' => ['auth'],
	]);

	// Agregar a un usuario como amigo
	Route::get('/amigos/agregar/{username}', [
		'uses' => '\Socialdaw\Http\Controllers\FriendController@getAdd',
		'as' => 'friends.add',
		'middleware' => ['auth'],
	]);

	// Aceptar una solicitud de amistad pendiente
	Route::get('/amigos/aceptar/{username}', [
		'uses' => '\Socialdaw\Http\Controllers\FriendController@getAccept',
		'as' => 'friends.accept',
		'middleware' => ['auth'],
	]);

	/*
	| Estados
	*/
	// Actualizar/Publicar un nuevo estado
	Route::post('estado', [
		'uses' => '\Socialdaw\Http\Controllers\StatusController@postEstado',
		'as' => 'status.post',
		'middleware' => ['auth'],
	]);
});
