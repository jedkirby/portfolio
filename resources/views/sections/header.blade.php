<header class="header">
    <div class="site__full">

        <div class="header__ident">
            <h1>
                <a href="{{ route('home') }}">{{ \Config::get('site.meta.title') }}</a>
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
                    <li><a href="{{ route('home') }}" class="{{ \Request::is('home', '/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('about') }}" class="{{ \Request::is('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('articles') }}" class="{{ \Request::is('blog', 'blog/*') ? 'active' : '' }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ \Request::is('contact', 'contact/*') ? 'active' : '' }}">Contact</a></li>
                </ul>
            </nav>
        </div>

    </div>
</header>
