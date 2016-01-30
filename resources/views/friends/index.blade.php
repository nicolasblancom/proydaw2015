@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<h3>Tus amigos</h3>
			@if(!$friends->count())
				<p>No tienes amigos agregados aún...</p>
			@else
				@foreach($friends as $user)
					@include('user.partials._userblock')
				@endforeach
			@endif
		</div>
		<div class="col-lg-6">
			<h4>Solicitudes de amistad</h4>
			@if(!$requests->count())
				<p>No tienes nuevas solicitudes de amistad...</p>
			@else
				@foreach($requests as $user)
					@include('user.partials._userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop