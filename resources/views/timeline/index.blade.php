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
			<!-- Estados del muro y respuestas -->
		</div>
	</div>
@stop