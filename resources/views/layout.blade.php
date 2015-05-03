<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8" /> 
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Prix des Loyers - @yield('title')</title>
		<meta name="description" content="Prix des Loyers" />
		<meta name="author" content="The Working Crew & Co" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap-theme.min.css" />
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" />
		<link rel="stylesheet" href="/style.css" />
	</head>
    <body role="document">

		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">Prix des Loyers</a>
				</div>
				<div id="navbar" class="">
					<ul class="nav navbar-nav">
						<!-- li class="active"><a href="#">Home</a></li -->
						<li><a href="/rent">Ajouter</a></li>
						<li><a href="/#about">À propos</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container" role="main">
			
			@yield('content')

		</div>

		<br/>
		<div class="container" role="footer">
			<blockquote>
				<footer>
					&copy; 2015 <a href="https://github.com/TheCitizenCrew">The Citizen Crew & Co</a><br/>
					Powered with Php, Lumen, Bootstrap, JQuery, Leaflet, CdnJs
				</footer>
			</blockquote>
		</div>

		@section('javascript')
			<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
		@show

	</body>
</html>
