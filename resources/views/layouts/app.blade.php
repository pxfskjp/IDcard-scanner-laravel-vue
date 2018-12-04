<!DOCTYPE html>
<html>
	<head>
		@include('templates/header')
	</head>
	<body id="app-layout">
		@include('templates/navbar')
		@include('templates/scripts')
		<div id="content">
			<div id="main">
				<div class="container">
					@yield('content')
				</div>
			</div>
		</div>
		<footer class="footer"></footer>
	</body>
</html>