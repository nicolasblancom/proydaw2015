<?php

namespace Socialdaw\Http\Controllers;

use Illuminate\Http\Request;
use Socialdaw\Models\User;

class AuthController extends Controller
{
	/**
	 * Muestra la pagina de registro.
	 *
	 * @return [type] [description]
	 */
	public function getRegistro(){
		return view('auth.registro');
	}

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
			->with('info', 'Has creado tu cuenta correctamente! Ya puedes iniciar sesión.');
	}
}