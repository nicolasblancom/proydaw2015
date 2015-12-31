<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<title>Socialdaw</title>
	</head>
	<body>

		@include('templates.partials._navigation')

		<div class="container">
			@yield('content')
		</div>

	</body>
</html>