<nav>
	<ul>
		<li><a href="{{ URL::to('articles') }}" {{ HTML::activeClass("articles") }} title="Ramblings on mostly Laravel and Application Development from the Land Down Under.">Articles</a></li>
		<li><a href="{{ URL::to('portfolio') }}" {{ HTML::activeClass("portfolio") }} title="Have a look at or use some of the open source code I've written.">Portfolio</a></li>
		<li><a href="{{ URL::to('about') }}" {{ HTML::activeClass("about") }} title="Learn all about me, Jason Lewis.">About</a></li>
		<li><a href="http://twitter.com/JJCLane" title="Follow me on Twitter as I tweet fairly often." target="_blank">Twitter</a></li>
		<li><a href="http://github.com/JJCLane" title="Follow my coding adventures on GitHub." target="_blank">GitHub</a></li>
		<li><a href="https://plus.google.com/116627112905853168457/" title="Circle me on Google+, although I'm not as active as I should be." target="_blank">Google+</a></li>
	</ul>
</nav>