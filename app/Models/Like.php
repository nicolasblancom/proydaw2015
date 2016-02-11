<?php

namespace Socialdaw\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
	/**
	 * Nombre de la tabla de la bd.
	 *
	 * @var string
	 */
	protected $table = 'gustable';

	/**
	 * Relacion polimorfica, puede ser aplicada a cualquier otro modelo.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function gustable()
	{
		return $this->morphTo();
	}

	/**
	 * Relacion uno a uno: 'un like pertenece a un usuario'.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function usuario()
	{
		return $this->belongsTo('Socialdaw\Models\User', 'usuario_id');
	}
}