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

						@foreach($posts as $id => $post)


							<article class="articles__article" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

								<h2 itemprop="headline"><a href="{{ \URL::to('blog', [$id]) }}" itemprop="url">{{ $post->getTitle() }}</a></h2>

								<time class="articles__article--metadata" pubdate="{{ $post->getDate() }}" itemprop="datePublished" datetime="{{ $post->getDate() }}" content="{{ $post->getDate() }}">{{ $post->getDate('F j, Y') }}</time>

								@if( ($image = $post->getImage()) )
									<a class="articles__article--link" href="{{ \URL::to('blog', [$id]) }}">
										<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $image }}" class="articles__article--hero  lazyload" alt="{{ $post->getTitle() }}">
									</a>
								@endif

								<div class="articles__article--summary">
									<p itemprop="articleBody">{{ $post->getSnippet() }} ...</p>
									<a href="{{ \URL::to('blog', [$id]) }}" class="articles__article--more">
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
