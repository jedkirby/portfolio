<!DOCTYPE html>
<html>
    <head>
        <title>{{ $title }}</title>
        <meta name="version" content="{{ client_version() }}">
        <meta name="description" content="{{ $description }}">
        <meta name="keywords" content="{{ $keywords }}">
        <meta name="author" content="{{ $author }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-site-verification" content="5oK0ivrxJyKh1zsSMbHewySVjxfZRALukAlInk8F7iI" />
        <meta property="fb:admins" content="732500050">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:url" content="{{ \URL::current() }}">
        @yield('header')
        @include('sections.favicons')
        @include('sections.typekit')
        <link href="{{ elixir('assets/css/build/main.css') }}" rel="stylesheet">
        @include('sections.ads')
    </head>
    <body class="@yield('id', 'home')" itemscope itemtype="http://schema.org/WebPage">

        <div class="site">
            @include('sections.header')
            @yield('content')
            @include('sections.footer')
        </div>

        @include('sections.analytics')

        <script src="{{ elixir('assets/js/build/vendor.js') }}"></script>
        <script src="{{ elixir('assets/js/build/app.js') }}"></script>

        @yield('footer')

    </body>
</html>
