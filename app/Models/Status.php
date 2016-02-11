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

	/**
	 * Relacion uno a muchos: 'un estado tiene muchas respuestas'.
	 *
	 * @return HasMany
	 */
	public function respuestas()
	{
		return $this->hasMany('Socialdaw\Models\Status', 'padre_id');
	}

	/**
	 * Relacion polimorfica una a muchos: 'un estado tiene muchos likes'.
	 *
	 * @return Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function likes()
	{
		return $this->morphMany('Socialdaw\Models\Like', 'gustable');
	}

	/**
	 * Scope para filtrar solo los estados que no sean una respuesta a otro estado.
	 *
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public function scopeNoRespuesta($query)
	{
		return $query->whereNull('padre_id');
	}
}