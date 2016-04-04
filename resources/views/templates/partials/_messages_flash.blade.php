@if(Session::has('info'))
	<div class="alert alert-info{{ Session::has('info_important') ? ' alert-important' : '' }}" role="alert">
		{{ Session::get('info') }}
		@if(Session::has('info_important'))
			<button type="button" class="button button-close" data-dismiss="alert" aria-hidden="true">&times;</button>
		@endif
	</div>
@endif