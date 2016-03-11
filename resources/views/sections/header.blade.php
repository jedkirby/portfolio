<header class="header">
	<div class="site__full">

		<div class="header__ident">
			<h1>
				<a href="{{ \URL::to('/') }}">{{ \Config::get('site.meta.title') }}</a>
			</h1>
		</div>

		<div class="header__handle">
			<div class="header__handle--inner  js-nav-toggle">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>

		<div class="header__nav  js-nav">
			<nav>
				<ul>
					<li><a href="{{ \URL::to('/') }}" class="{{ \Request::is('home', '/') ? 'active' : '' }}">Home</a></li>
					<li><a href="{{ \URL::to('about') }}" class="{{ \Request::is('about') ? 'active' : '' }}">About</a></li>
					<li><a href="{{ \URL::to('work') }}" class="{{ \Request::is('work', 'work/*') ? 'active' : '' }}">Work</a></li>
					<li><a href="{{ \URL::to('blog') }}" class="{{ \Request::is('blog', 'blog/*') ? 'active' : '' }}">Blog</a></li>
					<li><a href="{{ \URL::to('contact') }}" class="{{ \Request::is('contact', 'contact/*') ? 'active' : '' }}">Contact</a></li>
				</ul>
			</nav>
		</div>

	</div>
</header>
