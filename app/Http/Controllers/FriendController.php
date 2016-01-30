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
}
