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
}
