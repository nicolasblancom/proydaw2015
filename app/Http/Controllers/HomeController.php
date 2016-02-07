<?php

namespace Socialdaw\Http\Controllers;

use Auth;
use Socialdaw\Models\Status;

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
			// Recojo mis estados y los de mis amigos, ordeno y pagino
			$estados = Status::where(function($query){
				return $query
					->where('usuario_id', Auth::user()->id)
					->orWhereIn('usuario_id', Auth::user()->amigos()->lists('id'));
			})
				->orderBy('created_at', 'desc')
				->paginate(7);

			return view('timeline.index')
				->with('estados', $estados);
		}

		return view('home');
	}
}