@extends('templates.default')

@section('content')
	<img src="/img/portada.jpg" class="bgimg">
	<div class="text-center">
		<h3>Regístrate en Socialdaw y ponte en contacto con tus amigos de DAW</h3>
		<p>Una red social con estilo propio... </p>
		<p>Si has hecho <strong>Desarrollo de Aplicaciones Web</strong> <br/> debes estar dentro!</p>
		<ol class="list-inside">
			<li>Busca a tus amigos del módulo </li>
			<li>Envíales una solicitud de amistad</li>
			<li>Retoma el contacto y queda con ellos!</li>
		</ol>
		<p class="text-center">
			<a href="{{ route('auth.registro') }}" class="button cta1 big">Regístrate ahora!</a>
		</p>
	</div>
@stop