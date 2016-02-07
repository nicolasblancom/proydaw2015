<?php

namespace Socialdaw\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Socialdaw\Models\User;

class StatusController extends Controller
{
	/**
	 * Actualizar el nuevo estado publicado por el usuario.
	 *
	 * @param  Request $request
	 * @return redirect
	 */
	public function postEstado(Request $request)
	{
		$this->validate($request, [
			'estado' => 'required|max:1000',
		]);

		// Crear instancia del modelo Estados (en objetos y bd)
		Auth::user()->estados()->create([
			'body' => $request->input('estado'),
		]);

		$info = 'Tu estado ha sido actualizado!';

		return redirect()
			->route('home')
			->with('info', $info);
	}
}
