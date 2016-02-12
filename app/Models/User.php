<?php

namespace Socialdaw\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Socialdaw\Models\Status;

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
     * Relacion uno a muchos: 'usuario tiene muchos estados'.
     *
     * @return Illuminate/Database/Eloquent/Relations/HasMany
     */
    public function estados()
    {
        return $this->hasMany('Socialdaw\Models\Status', 'usuario_id');
    }

    public function likes()
    {
        return $this->hasMany('Socialdaw\Models\Like', 'usuario_id');
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

    /**
     * Obtener las solicitudes de amistad pendientes del usuario.
     *
     * @return [type] [description]
     */
    public function amigosSolicitudesPendientes()
    {
        return $this->amigoDe()->wherePivot('aceptado', false)->get();
    }

    /**
     * Comprobar si el usuario tiene solicitud de amistad pendiente de
     * aceptar por un usuario.
     *
     * @param  User   $user Usuario del que proviene la posible solicitud de amistad.
     * @return bool
     */
    public function tieneAmigoSolicitudPendiente(User $user)
    {
        return (bool) $this->amigosSolicitudesPendientes()
            ->where('id', $user->id)->count();
    }

    /**
     * Comprobar si el usuario tiene solicitud de amistad recibida desde otro usuario,
     * aun sin aceptar.
     *
     * @param  User   $user Usuario del que proviene la posible solicitud de amistad.
     * @return bool
     */
    public function tieneAmigoSolicitudRecibida(User $user)
    {
        return (bool) $this->amigosSolicitudes()->where('id', $user->id)->count();
    }

    /**
     * Agregar un usuario como amigo.
     *
     * @param  User   $user Usuario al que queremos agregar como amigo.
     * @return [type]       [description]
     */
    public function agregarAmigo(User $user)
    {
        return $this->amigoDe()->attach($user->id);
    }

    /**
     * Aceptar una solicitud de amistad de un usuario.
     *
     * @param  User   $user Usuario del cual queremos aceptar la solicitud de amistad.
     * @return [type]       [description]
     */
    public function aceptarAmigoSolicitud(User $user)
    {
        $this->amigosSolicitudes()->where('id', $user->id)->first()
            ->pivot->update([
                'aceptado' => true,
            ]);
    }

    public function esAmigoDe(User $user)
    {
        return (bool) $this->amigos()->where('id', $user->id)->count();
    }

    /**
     * Saber si un usuario ha dado me gusta a una estado.
     *
     * @param  Status $estado
     * @return bool
     */
    public function dioLikeEstado(Status $estado)
    {
        return (bool) $estado->likes->where('usuario_id', $this->id)->count();
    }
}
