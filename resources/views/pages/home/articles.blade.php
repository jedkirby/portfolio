@if($articles)

	<div class="articles" itemscope itemtype="http://schema.org/Blog">
		<div class="col--wrapper">

			@foreach($articles as $article)


				<article class="col  col--6" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

					<a href="{{ $article->getUrl() }}" class="article" itemprop="url">
						<img itemprop="image" src="{{ asset('assets/img/blank.png') }}" data-src="{{ $article->getImage() }}" class="article__image  lazyload" width="720" height="" />
						<div class="article__meta">
							<p class="article__date">
								<i class="fa fa-clock-o"></i>
								<time pubdate="{{ $article->getDate() }}" itemprop="datePublished" datetime="{{ $article->getDate() }}" content="{{ $article->getDate() }}">{{ $article->getDate('F j, Y') }}</time>
							</p>
							<h2 class="article__title" itemprop="headline">{{ $article->getTitle() }}</h2>
							<p class="article__sub" itemprop="articleBody">{{ $article->getSnippet() }}</p>
						</div>
					</a>

				</article>


			@endforeach

		</div>
	</div>

@endif
