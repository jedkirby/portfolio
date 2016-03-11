@extends('master')
@section('content')

	@if($projects)
		<div class="projects">
			<div class="site__full">

				<div class="col  col--10  projects__wrap">
					<div class="col--content  col--full">

						<div class="col--wrapper">

							@include('pages.projects.items')

						</div>

					</div>
				</div>

			</div>
		</div>
	@endif

@stop
