@extends('templates.default')

@section('content')
	<h3>Tu búsqueda para "{{ Request::input('query') }}"</h3>
	<div class="row">
		<div class="col-lg-12">
			@if(!$users->count())
				<p>No hay resultados...</p>
			@else
				@foreach($users as $user)
					@include('user.partials._userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop