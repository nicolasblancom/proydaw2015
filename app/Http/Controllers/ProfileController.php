<?php

namespace Socialdaw\Http\Controllers;

use Illuminate\Http\Request;
use Socialdaw\Models\User;

class ProfileController extends Controller
{
	/**
	 * Muestra la pagina de usuario individual.
	 *
	 * @param  string $username Nombre de usuario almacenado en bd (col 'username')
	 * @return view
	 */
    public function getPerfil($username){
    	// Comprobar que el nombre de usuario existe
    	$usuario = User::where('username', $username)->first();
    	if (!$usuario) {
    		abort(404);
    	}

    	return view('profile.index')
    		->with('user', $usuario);
    }
}
