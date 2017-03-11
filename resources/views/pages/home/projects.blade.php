@if($posts)
	<div class="projects">
		<div class="site__full">
			<div class="col--wrapper">


				<div class="col  col--12  text-center">

					<h2 class="projects__title">Latest Work</h2>

					<div class="col--wrapper  projects__items">
						@include('pages.projects.posts')
					</div>

					<a href="{{ \URL::to('work') }}" class="btn  btn__primary  projects__cta">See All</a>

				</div>


			</div>
		</div>
	</div>
@endif
