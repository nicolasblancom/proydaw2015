<div class="media">
	<a href="{{ route('profile.index', ['username' => $user->username]) }}" class="pull-left">
		<img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNombreCompletoOUsername() }}" class="media-object">
	</a>
	<div class="media-body">
		<h4 class="media-heading">
			<a href="{{ route('profile.index', ['username' => $user->username]) }}">
				{{ $user->getNombreCompletoOUsername() }}
			</a>
		</h4>
		@if($user->ubicacion)
			<p>{{ $user->ubicacion }}</p>
		@endif
	</div>
</div>