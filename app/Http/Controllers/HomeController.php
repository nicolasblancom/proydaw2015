<?php

namespace Socialdaw\Http\Controllers;

use Auth;

class HomeController extends Controller
{
	/**
	 * Muestra la pagina principal o home del sitio.
	 *
	 * @return view
	 */
	public function index() {

		// Si estoy logeado, muestro el timeline o muro
		if (Auth::check()) {
			return view('timeline.index');
		}

		return view('home');
	}
}