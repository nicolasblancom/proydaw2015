@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5">
			<!-- Info usuario y estados -->
			@include('user.partials._userblock')
			<hr>
		</div>
		<div class="col-lg-4 col-lg-offset-3">
			<!-- Amigos, peticiones de amistad -->
		</div>
	</div>
@stop