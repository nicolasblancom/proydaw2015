@extends('templates.default')

@section('content')
<h3>Registro</h3>
<div class="row">
	<div class="col-lg-6">
		<form action="{{ route('auth.registro') }}" class="control-label" role="form" method="post">
			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label for="email" class="control-label">Tu email</label>
				<input type="text" name="email" class="form-control" id="email" value="{{ old('email') }}">
				@if ($errors->has('email'))
				<span class="help-block">{{ $errors->first('email') }}</span>
				@endif
			</div>
			<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
				<label for="username" class="control-label">Elige usuario</label>
				<input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}">
				@if ($errors->has('username'))
				<span class="help-block">{{ $errors->first('username') }}</span>
				@endif
			</div>
			<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
				<label for="password" class="control-label">Elige password</label>
				<input type="password" name="password" class="form-control" id="password" value="">
				@if ($errors->has('password'))
				<span class="help-block">{{ $errors->first('password') }}</span>
				@endif
			</div>
			<div class="form-group">
				<button type="submit" class="button button__cta1">Regístrate</button>
			</div>
			<input type="hidden" name="_token" value="{{ Session::token() }}">
		</form>
	</div>
</div>
@stop