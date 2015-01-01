<!doctype html>

<html lang="en">
	<head>
		<title>{{ $title }} &ndash; Jordan Lane</title>

		<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
		<meta name="apple-mobile-web-app-title" content="Jordan Lane">
		<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
		<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
		<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
		<meta name="msapplication-TileColor" content="#da532c">
		<meta name="msapplication-TileImage" content="/mstile-144x144.png">
		<meta name="application-name" content="Jordan Lane">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="/assets/css/style.css">
		<link rel="alternate" type="application/rss+xml" title="Jordan Lane RSS Feed" href="{{ URL::to('rss') }}" />
		<link href='http://fonts.googleapis.com/css?family=Raleway:700,400' rel='stylesheet' type='text/css'>


	</head>

	<body onload="prettyPrint()">

		<div class="container">
			<header>
				<a href="{{ URL::to('/') }}"><img src="{{ URL::asset('assets/images/me.jpg') }}" /></a>

				@include('layouts.partial.navigation')
			</header>

			@if (isset($nav))
				<div class="side-nav">
					{{ $nav }}
				</div>
			@endif

			<div class="content">
				{{ $content }}
			</div>

			<footer>
				<div class="left">Copyright &copy; 2012 - {{ date('Y') }} Jordan Lane</div>
				<div class="right"><a href="#">Back To Top</a></div>
			</footer>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
		<script src="/assets/javascripts/prettify.js" type="text/javascript"></script>
		<script src="/assets/javascripts/website.js" type="text/javascript"></script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-58134424-1', 'auto');
		  ga('send', 'pageview');
		</script>
	</body>
</html>