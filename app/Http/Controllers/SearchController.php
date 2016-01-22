<?php

namespace Socialdaw\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Socialdaw\Models\User;

class SearchController extends Controller
{
	/**
	 * Muestra la pagina de resultados de busqueda de usuarios.
	 *
	 * @return view
	 */
    public function getResultados(Request $request) {
    	$query = $request->input('query');

    	// Redirijo a la home si no hay consulta de busqueda
    	if (!$query) {
    		return redirect()->route('home');
    	}

    	// Hago la consulta de busqueda
    	$users = User::where(DB::raw("CONCAT(nombre, ' ', apellidos)"), 'LIKE', "%{$query}%")
    		->orWhere('username', 'LIKE', "%{$query}%")
    		->get();

    	// Devuelvo la vista con resultados
    	return view('search.resultados')->with('users', $users);
    }
}
