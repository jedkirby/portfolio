@extends('master')

@section('id', 'blog')
@section('header')

    <meta property="og:type" content="article">

    <meta name="twitter:card" content="summary_large_image">
    <?php /*<meta name="twitter:site" content="{{ $twitterHandle }}" />*/ ?>
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

                    <div class="articles" itemscope itemtype="http://schema.org/Blog">


                        <article class="articles__article" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

                            <h2 itemprop="headline">{{ $article->getTitle() }}</h2>

                            <time class="articles__article--metadata" pubdate="{{ $article->getDate() }}" itemprop="datePublished" datetime="{{ $article->getDate() }}" content="{{ $article->getDate() }}">{{ $article->getDate('F j, Y') }}</time>

                            @if( ($image = $article->getImage()) )
                                <img itemprop="image" src="{{ asset('assets/img/blank.png') }}" data-src="{{ $image }}" class="articles__article--hero  lazyload">
                            @endif

                            <div class="articles__article--content" itemprop="articleBody">{!! $article->getContent() !!}</div>

                            <?php /*
                            <div class="social  articles__social">
                                <a href="{{ $social->facebook->shareUrl }}" class="btn  btn__icon  social__button  social__button--facebook" title="Facebook" target="_blank">
                                    <i class="fa fa-facebook"></i> <span>Facebook</span>
                                </a>
                                <a href="{{ $social->twitter->shareUrl }}" class="btn  btn__icon  social__button  social__button--twitter" title="Twitter" target="_blank">
                                    <i class="fa fa-twitter"></i> <span>Twitter</span>
                                </a>
                                <a href="{{ $social->plus->shareUrl }}" class="btn  btn__icon  social__button  social__button--google" title="Google Plus" target="_blank">
                                    <i class="fa fa-google"></i> <span>Google</span>
                                </a>
                                <a href="{{ $social->pinterest->shareUrl }}" class="btn  btn__icon  social__button  social__button--pinterest" title="Pinterest" target="_blank">
                                    <i class="fa fa-pinterest"></i> <span>Pinterest</span>
                                </a>
                            </div>
                            */?>

                        </article>


                    </div>

                </div>
            </div>


        </div>
    </div>

@stop
