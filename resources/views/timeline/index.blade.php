@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<form action="{{ route('status.post') }}" method="post" role="form">
				<div class="form-group{{ $errors->has('estado') ? ' has-error' : '' }}">
					<textarea name="estado" class="form-control" placeholder="¿En qué estás pensando {{ Auth::user()->getNombreOUsername() }}?"></textarea>
					@if($errors->has('estado'))
						<span class="help-block">{{ $errors->first('estado') }}</span>
					@endif
				</div>
				<button type="submit" class="button button__cta2">Actualizar estado</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-5">
			<!-- Timeline: sacar en partial -->
			@if(!$estados->count())
				<p>No hay nada en tu muro aun...</p>
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
										<li><a href="{{ route('status.deleteLike', ['estadoId' => $estado->id]) }}">Ya no me gusta</a></li>
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
										<a href="{{ route('profile.index', ['username' => $respuesta->usuario->username]) }}">
											{{ $respuesta->usuario->getNombreCompletoOUsername() }}
										</a>
									</h5>
									<p>{{ $respuesta->body }}</p>
									<ul class="list-inline">
										<li>{{ $respuesta->created_at->diffForHumans() }}</li>
										@if($respuesta->usuario->id !== Auth::user()->id)
											@if(Auth::user()->dioLikeEstado($respuesta))
												<li><a href="{{ route('status.deleteLike', ['estadoId' => $estado->id]) }}">Ya no me gusta</a></li>
											@else
												<li><a href="{{ route('status.like', ['estadoId' => $respuesta->id]) }}">Like</a></li>
											@endif

										@endif
										<li>{{ $respuesta->likes->count() }} {{ str_plural('like', $respuesta->likes->count()) }}</li>
									</ul>
								</div>
							</div>
							@endforeach

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
						</div>
					</div>
				@endforeach

				<!-- paginacion -->
				{{ $estados->render() }}
			@endif
		</div>
	</div>
@stop