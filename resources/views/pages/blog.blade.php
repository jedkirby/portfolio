@extends('master')

@section('id', 'blog')
@section('header')

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="{{ \Config::get('site.social.streams.twitter.handle') }}" />
    <meta name="twitter:title" content="{{ $title }}" />
    <meta name="twitter:description" content="{{ $description }}" />

@stop

@section('content')

    <div class="site__full">
        <div class="col--wrapper">


            <div class="col  col--12">
                <div class="col--content">
                    <div class="blog__articles" itemscope itemtype="http://schema.org/Blog">

                        @foreach($articles as $article)

                            <article class="article" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

                                <h3 itemprop="headline" class="article__title">
                                    <a href="{{ $article->getUrl() }}" itemprop="url">
                                        {{ $article->getTitle() }}
                                    </a>
                                </h3>

                                <time class="article__date" pubdate="{{ $article->getDateForMeta() }}" itemprop="datePublished" datetime="{{ $article->getDateForMeta() }}" content="{{ $article->getDateForMeta() }}">
                                    {{ $article->getDateForHuman() }}
                                </time>

                                @if( ($image = $article->getImage()) )
                                    <div class="article__hero">
                                        <a href="{{ $article->getUrl() }}">
                                            <img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $image }}" class="lazyload" alt="{{ $article->getTitle() }}">
                                        </a>
                                    </div>
                                @endif

                                <p itemprop="articleBody" class="article__snippet">
                                    {{ $article->getSnippet() }}..
                                </p>

                                <a href="{{ $article->getUrl() }}" class="article__link">
                                    <i class="fa fa-angle-double-right"></i> Read More
                                </a>

                            </article>

                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
