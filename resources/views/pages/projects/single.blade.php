@extends('master')
@section('content')

	<div class="single  js-project">

		<div class="site__medium  project">
			<div class="col--wrapper">


				<div class="col  col--12">
					<div class="col--content  col--full">


						<div class="project__intro">

							<h2>{{ array_get($project, 'title') }}</h2>
							<p class="project__sub">{{ array_get($project, 'sub') }}</p>

							@if( ($expired = array_get($project, 'expired')) )
								<p class="project__expired">{{ $expired }}</p>
							@endif

							{!! array_get($project, 'intro') !!}

							@if( ($link = array_get($project, 'link')) )
								<a href="{{ $link }}" class="btn  btn__primary  btn__icon" target="_blank">
									<i class="fa fa-globe"></i>
									Visit Site
								</a>
							@endif

						</div>


						@if( ($images = array_get($project, 'images')) )

							<div class="browser">
								<div class="browser__inner">

									<div class="browser__frame">
										<span class="js-browser-prev" title="Previous"></span>
										<span class="js-browser-pause" title="Play/Pause"></span>
										<span class="js-browser-next" title="Next"></span>
									</div>

									<div class="browser__slider  js-slider">
										@foreach($images as $src)
											<div class="browser__slider--slide"><img src="{{ $src }}" /></div>
										@endforeach
									</div>

								</div>
							</div>

						@endif


						<div class="project__content">
							{!! array_get($project, 'content') !!}
						</div>


						<div class="social  project__social">
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


					</div>
				</div>


			</div>
		</div>

		@if( ($testimonial = array_get($project, 'testi')) )

			<div class="testimonial">
				<div class="site__full">
					<div class="col--wrapper">

						<div class="col  col--12">
							<div class="col--content  col--no-bottom">

								<h3>Testimonial</h3>
								{!! $testimonial !!}

								<p class="testimonial__date">
									<i class="fa fa-clock-o"></i>
									{{ array_get($project, 'date')->format('F jS, Y') }}
								</p>

							</div>
						</div>

					</div>
				</div>
			</div>

		@endif

	</div>

@stop
