@extends('templates.default')

@section('content')
	<script>
		$(document).ready(function(){
			function revisarSolicitudes(){
				setInterval(function(){
					$.get(
					'{{ route("friends.solicitudesPend") }}',
					{
						'username' : 'nicolasblancom'
					},
					function(data){
						var solicitudesAntiguas = $("input[name='solicitudesNum']").val();
						var solicitudesNuevas = data.solicitudes;
						var mostrar = $("#solicitudesInfo");

						if (solicitudesNuevas > solicitudesAntiguas) {
							mostrar.addClass('highlight').html('Tienes solicitudes de amistad sin ver! <a href="{{ route('friends.index') }}">Recarga la página para verlas</a>');
							mostrar.parent().show();
						}else{
							mostrar.html('No tienes nuevas solicitudes de amistad');
							mostrar.removeClass('highlight');
						};
					},
					'json'
				);
				},2000);
			}

		});
	</script>
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
			<input type="hidden" name="solicitudesNum" value={{ $requests->count() }}>
			@if(!$requests->count())
				<p><span id="solicitudesInfo" style="display:inline-block;">No tienes nuevas solicitudes de amistad...</span></p>
			@else
				<p style="display:none;"><span id="solicitudesInfo" style="display:inline-block;"></span></p>
				@foreach($requests as $user)
					@include('user.partials._userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop