<?php

namespace Socialdaw\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Socialdaw\Models\User;

class AuthController extends Controller
{
	/**
	 * Muestra la pagina de registro.
	 *
	 * @return view
	 */
	public function getRegistro(){
		return view('auth.registro');
	}

	/**
	 * Da de alta un usuario en la bd
	 *
	 * @param  Request $request
	 * @return redirect
	 */
	public function postRegistro(Request $request){
		// Validacion
		$this->validate($request, [
			'email'    => 'required|unique:usuarios|email|max:255',
			'username' => 'required|unique:usuarios|alpha_dash|max:20',
			'password' => 'required|min:6',
		]);

		// Crear un usuario a partir del modelo
		User::create([
			'email'    => $request->input('email'),
			'username' => $request->input('username'),
			'password' => bcrypt( $request->input('password') ),
		]);

		// Devolver la vista
		return redirect()
			->route('home')
			->with('info', 'Has creado tu cuenta correctamente! Ya puedes iniciar sesión.')
			->with('info_important', true);
	}

	/**
	 * Muestra la pagina de login
	 *
	 * @return view
	 */
	public function getLogin()
	{
		return view('auth.login');
	}

	public function PostLogin(Request $request)
	{
		$this->validate($request, [
			'email'    => 'required',
			'password' => 'required',
		]);

		if( !Auth::attempt(
			$request->only(['email', 'password']),
			$request->has('recuerdame')) )
		{
			return redirect()->back()
				->with('info', 'Usuario o contraseña incorrectos. No se ha podido iniciar sesión.')
				->with('info_important', true);
		}

		return redirect()->route('home')->with('info', 'Usuario y contraseña correctos. Estás dentro de tu cuenta personal.');
	}

	public function getLogout()
	{
		Auth::logout();

		return redirect()->route('home')->with('info', 'Has salido de tu cuenta.');
	}
}