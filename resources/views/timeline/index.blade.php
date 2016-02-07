@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-6">
			<form action="#" method="post" role="form">
				<div class="form-group">
					<textarea name="estado" class="form-control" placeholder="¿En qué estás pensando Nicolas?"></textarea>
				</div>
				<button type="submit" class="btn btn-default">Actualiar estado</button>
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