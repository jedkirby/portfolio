@if($articles)
	<div class="articles" itemscope itemtype="http://schema.org/Blog">
		<div class="col--wrapper">


			@foreach($articles as $slug => $article)


				<article class="col  col--6" itemprop="blogPosts" itemscope itemtype="http://schema.org/BlogPosting">

					<a href="{{ \URL::to('/blog/'.$slug) }}" class="article" itemprop="url">
						<img itemprop="image" src="{{ asset('assets/img/blank.png') }}" data-src="{{ ( array_get($article, 'image', false) ?: 'http://placehold.it/720x400' ) }}" class="article__image  lazyload" width="720" height="" />
						<div class="article__meta">
							<p class="article__date">
								<i class="fa fa-clock-o"></i>
								<time pubdate="{{ array_get($article, 'date')->format('Y-m-d') }}" itemprop="datePublished" datetime="{{ array_get($article, 'date')->format('Y-m-d') }}" content="{{ array_get($article, 'date')->format('Y-m-d') }}">{{ array_get($article, 'date')->format('F j, Y') }}</time>
							</p>
							<h2 class="article__title" itemprop="headline">{{ array_get($article, 'title') }}</h2>
							<p class="article__sub" itemprop="articleBody">{{ array_get($article, 'snippet') }}</p>
						</div>
					</a>

				</article>


			@endforeach


		</div>
	</div>
@endif
