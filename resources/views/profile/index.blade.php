@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5">
			<!-- Info usuario y estados -->
			@include('user.partials._userblock')
			<hr>

			<!-- Timeline del propio usuario: sacar en partial -->
			@if(!$estados->count())
				<p>{{ $user->getNombreCompletoOUsername() }} no ha escrito nada aún...</p>
			@else
				@foreach($estados as $estado)
					<div class="media">
						<a
							href="{{ route('profile.index', ['username' => $estado->usuario->username]) }}"
							class="pull-left">
							<img
								src="{{ $estado->usuario->getAvatarUrl() }}"
								alt="{{ $estado->usuario->getNombreCompletoOUsername() }}"
								class="media-object">
						</a>
						<div class="media-body">
							<h4 class="media-heading">
								<a href="{{ route('profile.index', ['username' => $estado->usuario->username]) }}">
									{{ $estado->usuario->getNombreCompletoOUsername() }}
								</a>
							</h4>
							<p>{{ $estado->body }}</p>
							<ul class="list-inline">
								<li>{{ $estado->created_at->diffForHumans() }}</li>
							</ul>

							@foreach($estado->respuestas as $respuesta)
							<div class="media">
								<a href="{{ route('profile.index', ['username' => $respuesta->usuario->username]) }}" class="pull-left">
									<img
										src="{{ $respuesta->usuario->getAvatarUrl() }}"
										alt="{{ $respuesta->usuario->getNombreCompletoOUsername() }}"
										class="media-object">
								</a>
								<div class="media-body">
									<h5 class="media-heading">
										<a href="{{ route('profile.index', ['username' => $respuesta->usuario->username]) }}">
											{{ $respuesta->usuario->getNombreCompletoOUsername() }}
										</a>
									</h5>
									<p>{{ $respuesta->body }}</p>
									<ul class="list-inline">
										<li>{{ $respuesta->created_at->diffForHumans() }}</li>
										@if($respuesta->usuario->id !== Auth::user()->id)
											<li><a href="{{ route('status.like', ['estadoId' => $respuesta->id]) }}">Like</a></li>
											<li>25 likes</li>
										@endif
									</ul>
								</div>
							</div>
							@endforeach

							@if($authUsuarioEsAmigo || Auth::user()->id === $estado->usuario->id)
								<form action="{{ route('status.respuesta', ['estadoId' => $estado->id]) }}" role="form" method="post">
									<div class="form-group{{ $errors->has("respuesta-{$estado->id}") ? ' has-error' : '' }}">
										<textarea name="respuesta-{{ $estado->id }}" rows="2" class="form-control" placeholder="Responder a este estado"></textarea>
										@if($errors->has("respuesta-{$estado->id}"))
											<span class="help-block">{{ $errors->first("respuesta-{$estado->id}") }}</span>
										@endif
									</div>
									<input type="hidden" name="_token" value="{{ Session::token() }}">
									<input type="submit" value="Responder" class="btn btn-default btn-sm">
								</form>
							@endif
						</div>
					</div>
				@endforeach
			@endif
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
			@elseif(Auth::user()->id !== $user->id)
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