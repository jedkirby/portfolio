@if($instagram)

	<div class="instagram">
		<div class="site__medium">
			<div class="col--wrapper">


				<div class="col  col--12">

					<div class="instagram__icon">
						<a href="{{ \Config::get('site.social.streams.instagram.url') }}" title="View my Instagram" target="_blank">
							<i class="fa fa-instagram"></i>
						</a>
					</div>

					<div class="instagram__items">

						@foreach($instagram as $post)

							<div class="instagram__post">

								<a href="{{ array_get($post, 'link') }}" target="_blank">

									<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ array_get($post, 'images.low_resolution.url') }}" title="{{ array_get($post, 'caption.text', 'No Caption') }}" class="lazyload" />

								</a>

							</div>

						@endforeach

					</div>

				</div>


			</div>
		</div>
	</div>

@endif
