@foreach($projects as $id => $project)

	<a href="{{ URL::to('work/' . $id) }}" title="{{ $project->getTitle() }}">

		<div class="col--4  project">
			<div class="project__content">

				<img src="{{ asset('assets/img/blank.png') }}" data-src="{{ $project->getHero() }}" class="project__image  lazyload" alt="{{ $project->getTitle() }}" width="315" height="315" />

				<div class="project__meta">
					<h4 class="project__title">{{ $project->getTitle() }}</h4>
					<p class="project__sub">{{ $project->getSubTitle() }}</p>
					<i class="{{ $project->getIcon() }} project__icon"></i>
				</div>

			</div>
		</div>

	</a>

@endforeach
