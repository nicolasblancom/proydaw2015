@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<!-- Info usuario y estados -->
			<div class="userblock">
				<h4 class="userblock__tit"><em>Perfil de</em></h4>
				@include('user.partials._userblock')
			</div>

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
								<a href="{{ route('profile.index', ['username' => $estado->usuario->username]) }}" class="profileUsername">
									{{ $estado->usuario->getNombreCompletoOUsername() }}
								</a>
							</h4>
							<p>{{ $estado->body }}</p>
							<ul class="list-inline">
								<li>{{ $estado->created_at->diffForHumans() }}</li>
								@if($estado->usuario->id !== Auth::user()->id)
									@if(Auth::user()->dioLikeEstado($estado))
										<li><a href="#">Ya no me gusta</a></li>
									@else
										<li><a href="{{ route('status.like', ['estadoId' => $estado->id]) }}">Like</a></li>
									@endif
								@endif
								<li>{{ $estado->likes->count() }} {{ str_plural('like', $estado->likes->count()) }}</li>
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
										<a href="{{ route('profile.index', ['username' => $respuesta->usuario->username]) }}" class="profileUsername">
											{{ $respuesta->usuario->getNombreCompletoOUsername() }}
										</a>
									</h5>
									<p>{{ $respuesta->body }}</p>
									<ul class="list-inline">
										<li>{{ $respuesta->created_at->diffForHumans() }}</li>
										@if($respuesta->usuario->id !== Auth::user()->id)
											@if(Auth::user()->dioLikeEstado($respuesta))
												<li><a href="#">Ya no me gusta</a></li>
											@else
												<li><a href="{{ route('status.like', ['estadoId' => $respuesta->id]) }}">Like</a></li>
											@endif
										@endif
										<li>{{ $respuesta->likes->count() }} {{ str_plural('like', $respuesta->likes->count()) }}</li>
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
									<button type="submit" class="button button__cta2">Responder</button>
								</form>
							@endif
						</div>
					</div>
				@endforeach
			@endif
		</div>
		<div class="col-lg-4 col-lg-offset-2">
			<div class="amistad">
				<!-- Solicitudes que ha enviado y aun sin aceptar -->
				@if(Auth::user()->tieneAmigoSolicitudPendiente($user))
					<p class="amistad__estado">{{ $user->getNombreOUsername() }} aún no ha aceptado tu solicitud...</p>
				@elseif(Auth::user()->tieneAmigoSolicitudRecibida($user))
				<!-- Boton para aceptar solicitudes pendientes -->
					<a href="{{ route('friends.accept', ['username' => $user->username]) }}" class="button button__cta2">Aceptar amistad</a>
				@elseif(Auth::user()->esAmigoDe($user))
				<!-- Mensaje de relacion de amistad y boton de eliminar amistad -->
					<p class="amistad__estado">Tú y {{ $user->getNombreOUsername() }} sois amigos</p>

					<form action="{{ route('friends.delete', ['username' => $user->username]) }}" method="POST">
						<button type="submit" class="button button__cta1">Eliminar amistad</button>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
					</form>

				@elseif(Auth::user()->id !== $user->id)
				<!-- Boton para solicitar amistad -->
					<a href="{{ route('friends.add', ['username' => $user->username]) }}" class="button button__cta3">Solicitar amistad</a>
				@endif
			</div>

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