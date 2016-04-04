<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Socialdaw</title>

		<link rel="stylesheet" href="/output/css/all.css">
		<script src="/output/js/all.js"></script>
	</head>
	<body>

		@include('templates.partials._navigation')

		<div class="container">
			@include('templates.partials._messages_flash')
			@yield('content')
		</div>

	</body>
</html>