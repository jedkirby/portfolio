@extends('master')

@section('id', 'work')
@section('content')

	@if($posts)
		<div class="projects">
			<div class="site__full">

				<div class="col  col--10  projects__wrap">
					<div class="col--content  col--full">

						<div class="col--wrapper">

							@include('pages.projects.posts')

						</div>

					</div>
				</div>

			</div>
		</div>
	@endif

@stop
