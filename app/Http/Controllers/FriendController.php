<?php

namespace Socialdaw\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialdaw\Models\User;

class FriendController extends Controller
{
	/**
	 * Muestra la pagina principal de amigos.
	 * @return view
	 */
    public function getIndex()
    {
    	$friends = Auth::user()->amigos();
        $requests = Auth::user()->amigosSolicitudes();

    	return view('friends.index')
    		->with('friends', $friends)
            ->with('requests', $requests);
    }

    /**
     * Agregar a un usuario como amigo.
     *
     * @param  string $username Username del usuario que queremos agregar como amigo
     * @return redirect
     */
    public function getAdd($username)
    {
        $user = User::where('username', $username)->first();

        // Comprobar si el usuario existe
        if (!$user) {
            $info = "El usuario $user->username no existe...";

            return redirect()
                ->route('home')
                ->with('info', $info);
        }

        // Comprobar si ya hay una solicitud de amistad pendiente de aceptar tanto
        // del usuario autenticado hacia el usuario a agregar, como al reves
        if( Auth::user()->tieneAmigoSolicitudPendiente($user) ||
            $user->tieneAmigoSolicitudPendiente(Auth::user()) ){
            $info = "Ya hay una solicitud de amistad pendiente con $user->username...";

            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', $info);
        }

        // Comprobar si ya hay amistad entre los usuarios
        if (Auth::user()->esAmigoDe($user)) {
            $info = "Tú y $user->username, ya sois amigos...";

            return redirect()
                ->route('profile.index', ['username' => $user->username])
                ->with('info', $info);
        }

        // Agrego relacion de amistad entre los usuarios
        Auth::user()->agregarAmigo($user);

        $info = "Solicitud de amistad enviada a $username";

        return redirect()
            ->route('profile.index', ['username' => $user->username])
            ->with('info', $info);
    }
}
