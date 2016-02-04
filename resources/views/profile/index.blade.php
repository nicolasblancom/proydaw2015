@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5">
			<!-- Info usuario y estados -->
			@include('user.partials._userblock')
			<hr>
		</div>
		<div class="col-lg-4 col-lg-offset-3">
			<!-- Solicitudes que ha enviado y aun sin aceptar -->
			@if(Auth::user()->tieneAmigoSolicitudPendiente($user))
				<p>{{ $user->getNombreOUsername() }} aún no ha aceptado tu solicitud...</p>
			@elseif(Auth::user()->tieneAmigoSolicitudRecibida($user))
			<!-- Boton para aceptar solicitudes pendientes -->
				<a href="{{ route('friends.accept', ['username' => $user->username]) }}" class="btn btn-primary">Aceptar amistad</a>
			@elseif(Auth::user()->esAmigoDe($user))
			<!-- Mensaje de reacion de amistad -->
				<p>Tú y {{ $user->getNombreOUsername() }} sois amigos</p>
			@else
			<!-- Boton para solicitar amistad -->
				<a href="{{ route('friends.add', ['username' => $user->username]) }}" class="btn btn-primary">Solicitar amistad</a>
			@endif

			<h4>Amigos de {{ $user->getNombreOUsername() }}</h4>
			@if(!$user->amigos()->count())
				<p>{{ $user->getNombreOUsername() }} no tiene amigos agregados aún...</p>
			@else
				@foreach($user->amigos() as $user)
					@include('user.partials._userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop