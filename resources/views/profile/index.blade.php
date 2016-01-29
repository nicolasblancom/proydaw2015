@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5">
			<!-- Info usuario y estados -->
			@include('user.partials._userblock')
			<hr>
		</div>
		<div class="col-lg-4 col-lg-offset-3">
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