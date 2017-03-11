@foreach($posts as $id => $post)

	<a href="{{ URL::to('work/' . $id) }}" title="{{ $post->getTitle() }}">

		<div class="col--4  project">
			<div class="project__content">

				<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $post->getHero() }}" class="project__image  lazyload" alt="{{ $post->getTitle() }}" width="315" height="315" />

				<div class="project__meta">
					<h4 class="project__title">{{ $post->getTitle() }}</h4>
					<p class="project__sub">{{ $post->getSubTitle() }}</p>
					<i class="{{ $post->getIcon() }} project__icon"></i>
				</div>

			</div>
		</div>

	</a>

@endforeach
