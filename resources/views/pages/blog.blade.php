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

						@foreach($articles as $article)

							<article class="articles__article" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

								<h2 itemprop="headline"><a href="#" itemprop="url">{{ $article->name }}</a></h2>

								<time class="articles__article--metadata" pubdate="" itemprop="datePublished" datetime="" content="">{{ \DateTime::createFromFormat(\DateTime::ATOM, $article->date)->format('F j, Y') }}</time>

								@if( ($image = $article->image) )
									<a class="articles__article--link" href="#">
										<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $image }}" class="articles__article--hero  lazyload">
									</a>
								@endif

								<div class="articles__article--summary">
									<p itemprop="articleBody">{{ $article->content }}..</p>
									<a href="#" class="articles__article--more">
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
