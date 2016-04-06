<!DOCTYPE html>
<html lang="es" style="position:relative; min-height: 100%;">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Socialdaw</title>

		<link rel="stylesheet" href="/output/css/all.css">
		<script src="/output/js/all.js"></script>
	</head>
	<body style="margin-bottom: 60px;">
		<div class="mainWrapper">
			@include('templates.partials._navigation')

			<div class="container" style="padding-bottom:45px;">
				@include('templates.partials._messages_flash')
				@yield('content')
			</div>

			@include('templates.partials._footer')
		</div>
	</body>
</html>