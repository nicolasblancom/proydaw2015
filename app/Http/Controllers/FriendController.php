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

        // Comprobar que no estemos agregandonos a nosotros mismos
        if (Auth::user()->id === $user->id) {
            return redirect()->route('home');
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
            ->with('info', $info)
            ->with('info_important', true);
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        // Comprobar si el usuario existe
        // REFACTOR: hacer metodo protected
        if (!$user) {
            $info = "El usuario $username no existe...";

            return redirect()
                ->route('home')
                ->with('info', $info);
        }

        // Comprobar que hemos recibido realmente una solicitud de ese usuario
        if (!Auth::user()->tieneAmigoSolicitudRecibida($user)) {
            $info = "No tenías ninguna solicitud de amistad de $username...";

            return redirect()
                ->route('home')
                ->with('info', $info);
        }

        Auth::user()->aceptarAmigoSolicitud($user);

        $info = "Solicitud de amistad de $username aceptada";

        return redirect()
            ->route('profile.index', ['username' => $username])
            ->with('info', $info);
    }

    /**
     * Eliminar la relacion de amistad con un usuario.
     *
     * @param  string $username
     * @return redirect
     */
    public function postDelete($username)
    {
        $user = User::where('username', $username)->first();

        // Si no hay amistad entre los usuarios
        if (!Auth::user()->esAmigoDe($user)) {
            return redirect()->back();
        }

        // Eliminar la amistad
        Auth::user()->eliminarAmigo($user);

        return redirect()->back()
            ->with('info', 'Amistad eliminada.')
            ->with('info_important', true);
    }
}
