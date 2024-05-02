<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@env('APP_NAME')@endenv</title>
		@vite
	</head>
	<body class="antialiased bg-gray-100">
		@inertia
	</body>
</html>
