@extends('master')

@section('id', 'blog')
@section('header')

    <meta property="og:type" content="article">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="{{ \Config::get('site.social.streams.twitter.handle') }}" />
    <meta name="twitter:title" content="{{ $title }}" />
    <meta name="twitter:description" content="{{ $description }}" />

    @if( ($image = $article->getImage()) )
        <meta property="og:image" content="{{ $image }}">
        <meta name="twitter:image" content="{{ $image }}">
    @endif

@stop

@section('content')

    <div class="site__medium">
        <div class="col--wrapper">


            <div class="col  col--12">
                <div class="col--content">
                    <div class="blog__article" itemscope itemtype="http://schema.org/Blog">

                        <article class="article" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

                            <h2 itemprop="headline" class="article__title">
                                {{ $article->getTitle() }}
                            </h2>

                            <time class="article__date" pubdate="{{ $article->getDateForMeta() }}" itemprop="datePublished" datetime="{{ $article->getDateForMeta() }}" content="{{ $article->getDateForMeta() }}">
                                {{ $article->getDateForHuman() }}
                            </time>

                            @if( ($image = $article->getImage()) )
                                <div class="article__hero">
                                    <img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $image }}" class="lazyload" alt="{{ $article->getTitle() }}">
                                </div>
                            @endif

                            <div class="article__content" itemprop="articleBody">
                                {!! $article->getContent() !!}
                            </div>

                            <div class="article__social  social">
                                <a href="{{ $page->facebook->shareUrl }}" class="btn  btn__icon  social__button  social__button--facebook" title="Facebook" target="_blank">
                                    <i class="fa fa-facebook"></i> <span>Facebook</span>
                                </a>
                                <a href="{{ $page->twitter->shareUrl }}" class="btn  btn__icon  social__button  social__button--twitter" title="Twitter" target="_blank">
                                    <i class="fa fa-twitter"></i> <span>Twitter</span>
                                </a>
                                <a href="{{ $page->plus->shareUrl }}" class="btn  btn__icon  social__button  social__button--google" title="Google Plus" target="_blank">
                                    <i class="fa fa-google"></i> <span>Google</span>
                                </a>
                                <a href="{{ $page->pinterest->shareUrl }}" class="btn  btn__icon  social__button  social__button--pinterest" title="Pinterest" target="_blank">
                                    <i class="fa fa-pinterest"></i> <span>Pinterest</span>
                                </a>
                            </div>

                        </article>

                    </div>
                </div>
            </div>


        </div>
    </div>

@stop
