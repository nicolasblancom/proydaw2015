<?php

namespace Socialdaw\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'nombre',
        'apellidos',
        'ubicacion',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Obtener el nombre del usuario.
     *
     * @return string
     */
    public function getNombre()
    {
        if( $this->nombre && $this->apellidos ){
            return "{$this->nombre} {$this->apellidos}";
        }

        if( $this->nombre ){
            return "{$this->nombre}";
        }

        return null;
    }

    /**
     * Obtener el nombre completo o si no esta disponible, el nombre de usuario
     *
     * @return string
     */
    public function getNombreCompletoOUsername()
    {
        return $this->getNombre() ?: $this->username;
    }

    /**
     * Obtener el nombre o si no esta disponible, el nombre de usuario
     *
     * @return string
     */
    public function getNombreOUsername()
    {
        return $this->nombre ?: $this->username;
    }

    /**
     * Obtener la url de la imagen de gravatar desde el email del usuario.
     *
     * @return string
     */
    public function getAvatarUrl()
    {
        $hash = md5($this->email);
        return "http://www.gravatar.com/avatar/$hash?d=mm&s=45";
    }

    /**
     * Relacion relfexiva: 'amigos del usuario'.
     *
     * @return Illuminate/Database/Eloquent/Relations/BelongsToMany
     */
    public function amigosMios()
    {
        return $this->belongsToMany('Socialdaw\Models\User', 'amigos', 'usuario_id', 'amigo_id');
    }

    /**
     * Relacion reflexiva: 'usuario es amigo de'.
     *
     * @return Illuminate/Database/Eloquent/Relations/BelongsToMany
     */
    public function amigoDe()
    {
        return $this->belongsToMany('Socialdaw\Models\User', 'amigos', 'amigo_id', 'usuario_id');
    }

    /**
     * Obtener los amigos del usuario.
     * Bidireccional ('u1 amigo de u2' y 'u2 amigo de u1'), representado
     * mediante la solicitud de amistad aceptada por ambas partes.
     *
     * @return Illuminate\Support\Collection
     */
    public function amigos()
    {
        return $this->amigosMios()->wherePivot('aceptado', true)->get()->merge($this->amigoDe()->wherePivot('aceptado', true)->get());
    }

    /**
     * Obtener las solicitudes de amistad del usuario. Son 'amistades sin aceptar'.
     *
     * @return [type] [description]
     */
    public function amigosSolicitudes()
    {
        return $this->amigosMios()->wherePivot('aceptado', false)->get();
    }
}
