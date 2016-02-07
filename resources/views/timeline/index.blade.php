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
				<button type="submit" class="btn btn-default">Actualiar estado</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-5">
			<!-- Timeline -->
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
								<a href="{{ route('profile.index', ['username' => $estado->usuario->username]) }}">
									{{ $estado->usuario->getNombreCompletoOUsername() }}
								</a>
							</h4>
							<p>{{ $estado->body }}</p>
							<ul class="list-inline">
								<li>{{ $estado->created_at->diffForHumans() }}</li>
								<li><a href="#">Like</a></li>
								<li>25 likes</li>
							</ul>

							<!--<div class="media">
								<a href="#" class="pull-left">
									<img src="" alt="" class="media-object">
								</a>
								<div class="media-body">
									<h5 class="media-heading"><a href="">Juan</a></h5>
									<p>Sí que es verdad!</p>
									<ul class="list-inline">
										<li>Hace 30 minutos</li>
										<li><a href="#">Like</a></li>
										<li>25 likes</li>
									</ul>
								</div>
							</div>-->

							<form action="#" role="form" method="post">
								<div class="form-group">
									<textarea name="respuesta-1" rows="2" class="form-control" placeholder="Responder a este estado"></textarea>
								</div>
								<input type="submit" value="Responder" class="btn btn-default btn-sm">
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