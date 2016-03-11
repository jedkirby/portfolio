@extends('master')
@section('header')

	<meta name="twitter:card" content="summary" />
	<meta name="twitter:site" content="{{ $twitterHandle }}" />
	<meta name="twitter:title" content="{{ $title }}" />
	<meta name="twitter:description" content="{{ $description }}" />

@stop
@section('content')

	<div class="site__medium">
		<div class="col--wrapper">


			<div class="col  col--12">
				<div class="col--content">

					<div class="articles" itemscope itemtype="http://schema.org/Blog">

						@foreach($articles as $slug => $article)


							<article class="articles__article" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

								<h2 itemprop="headline"><a href="{{ \URL::to('blog', [$slug]) }}" itemprop="url">{{ array_get($article, 'title') }}</a></h2>

								<time class="articles__article--metadata" pubdate="{{ array_get($article, 'date')->format('Y-m-d') }}" itemprop="datePublished" datetime="{{ array_get($article, 'date')->format('Y-m-d') }}" content="{{ array_get($article, 'date')->format('Y-m-d') }}">{{ array_get($article, 'date')->format('F j, Y') }}</time>

								@if( ($image = array_get($article, 'image', false)) )
									<a class="articles__article--link" href="{{ \URL::to('blog', [$slug]) }}">
										<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $image }}" class="articles__article--hero  lazyload">
									</a>
								@endif

								<div class="articles__article--summary">
									<p itemprop="articleBody">{{ array_get($article, 'snippet') }} ...</p>
									<a href="{{ \URL::to('blog', [$slug]) }}" class="articles__article--more">
										<i class="fa fa-angle-double-right"></i>
										Read More
									</a>
								</div>

							</article>


						@endforeach

					</div>

				</div>
			</div>


		</div>
	</div>

@stop
