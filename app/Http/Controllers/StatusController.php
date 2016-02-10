<?php

namespace Socialdaw\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Socialdaw\Models\Status;
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

	/**
	 * Responder a un estado.
	 *
	 * @param  Request $request
	 * @param  int  $estadoId Id del estado al que estamos respondiendo
	 * @return redirect
	 */
	public function postRespuesta(Request $request, $estadoId)
	{
		$this->validate($request, [
			"respuesta-{$estadoId}" => 'required|max:1000',
		], [
			'required' => 'No has introducido la respuesta...'
		]);

		$estado = Status::noRespuesta()->find($estadoId);

		// Si no existe ese estado
		if(!$estado){
			return redirect()->route('home');
		}

		// Si no son amigos y no me estoy respondiendo a mi mismo
		if (!Auth::user()->esAmigoDe($estado->usuario) && Auth::user()->id !== $estado->usuario->id ){
			return redirect()->route('home');
		}

		// Crear el nuevo estado y asociarle una clave ajena correspondiente (id del estado padre en este caso)
		$respuesta = Status::create([
			'body' => $request->input("respuesta-{$estadoId}"),
		])->usuario()->associate(Auth::user());

		// Guardar la respuesta
		$estado->respuestas()->save($respuesta);

		return redirect()->back();

	}
}
