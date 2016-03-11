@foreach($projects as $slug => $project)

	<a href="{{ \URL::to('work/'.$slug) }}" title="{{ array_get($project, 'title') }}">

		<div class="col--4  project">
			<div class="project__content">

				<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ array_get($project, 'hero') }}" class="project__image  lazyload" alt="{{ array_get($project, 'title') }}" width="315" height="315" />

				<div class="project__meta">
					<h4 class="project__title">{{ array_get($project, 'title') }}</h4>
					<p class="project__sub">{{ array_get($project, 'sub') }}</p>
					<i class="{{ array_get($project, 'icon') }} project__icon"></i>
				</div>

			</div>
		</div>

	</a>

@endforeach
