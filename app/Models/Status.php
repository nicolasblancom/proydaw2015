<?php

namespace Socialdaw\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	/**
	 * Nombre de la tabla a la que hace referencia el modelo.
	 *
	 * @var string
	 */
	protected $table = 'estados';

	/**
     * Atributos asignables masivamente.
     *
     * @var array
     */
	protected $fillable = [
		'body',
	];

	/**
	 * Relacion uno a uno: 'un estado pertenece a un usuario'.
	 *
	 * @return [type] [description]
	 */
	public function usuario()
	{
		return $this->belongsTo('Socialdaw\Models\User', 'usuario_id');
	}
}