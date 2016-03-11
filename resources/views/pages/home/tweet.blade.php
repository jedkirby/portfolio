@if($tweet)
	<div class="tweet">
		<div class="site__medium">
			<div class="col--wrapper">


				<div class="col  col--12">

					<div class="tweet__icon">
						<a href="{{ $tweet->getLink() }}" title="View my Twitter" target="_blank">
							<i class="fa fa-twitter"></i>
						</a>
					</div>

					<p class="tweet__text">
						{!! $tweet->getText() !!}
					</p>

					@if($tweet->hasLocation() || $tweet->hasRetweets() || $tweet->hasFavorites())
						<ul class="tweet__meta">

							@if($tweet->hasLocation())
								<li><i class="fa fa-map-marker"></i> {{ $tweet->getLocation() }}</li>
							@endif

							@if($tweet->hasRetweets())
								<li><i class="fa fa-retweet"></i> {!! $tweet->getRetweetCount() !!}</li>
							@endif

							@if($tweet->hasFavorites())
								<li><i class="fa fa-heart"></i> {!! $tweet->getFavoriteCount() !!}</li>
							@endif

						</ul>
					@endif

				</div>

			</div>
		</div>
	</div>
@endif
