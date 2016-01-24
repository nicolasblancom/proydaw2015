<?php

namespace Socialdaw\Http\Controllers;

use Auth;
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

    /**
     * Muestra la pagina de edicion de datos de usuario.
     *
     * @return view
     */
    public function getEdit(){
        return view('profile.edit');
    }

    public function postEdit(Request $request){
        $this->validate($request, [
            'nombre' => [
                'max:50',
                'regex:/^[\pL\s]+$/u',
            ],
            'apellidos' => [
                'max:50',
                'regex:/^[\pL\s]+$/u',
            ],
            'ubicacion' => 'max:30',
        ]);

        Auth::user()->update([
            'nombre' => $request->input('nombre'),
            'apellidos' => $request->input('apellidos'),
            'ubicacion' => $request->input('ubicacion'),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('info', 'Tu perfil ha sido actualizado.');
    }
}
