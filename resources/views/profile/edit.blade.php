@extends('templates.default')

@section('content')
	<h3>Actualiza tu perfil</h3>
	<div class="row">
		<div class="col-lg-6">
			<form action="{{ route('profile.edit') }}" class="form-vertical" role="form" method="post">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
							<label for="nombre" class="control-label">Nombre</label>
							<input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') ?: Auth::user()->nombre }}">
							@if($errors->has('nombre'))
								<span class="help-block">{{$errors->first('nombre')}}</span>
							@endif
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
							<label for="apellidos" class="control-label">Apellidos</label>
							<input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ old('apellidos') ?: Auth::user()->apellidos }}">
							@if($errors->has('apellidos'))
								<span class="help-block">{{$errors->first('apellidos')}}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="form-group{{ $errors->has('ubicacion') ? ' has-error' : '' }}">
					<label for="ubicacion" class="control-label">Ubicación</label>
					<input type="text" name="ubicacion" id="ubicacion" class="form-control" value="{{ old('ubicacion') ?: Auth::user()->ubicacion }}">
					@if($errors->has('ubicacion'))
						<span class="help-block">{{$errors->first('ubicacion')}}</span>
					@endif
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default">Actualizar</button>
				</div>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
		</div>
	</div>
@stop