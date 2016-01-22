<div class="media">
	<a href="#" class="pull-left">
		<img src="" alt="{{ $user->getNombreCompletoOUsername() }}" class="media-object">
	</a>
	<div class="media-body">
		<h4 class="media-heading">
			<a href="">{{ $user->getNombreCompletoOUsername() }}</a>
		</h4>
		@if($user->ubicacion)
			<p>{{ $user->ubicacion }}</p>
		@endif
	</div>
</div>