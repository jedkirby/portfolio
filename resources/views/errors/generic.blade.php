@extends('master')
@section('content')

	<div class="site__medium">
		<div class="col--wrapper">
			<div class="error__wrap  text-center">

				<h1 class="error__heading">{{ $status }}</h1>
				<p class="error__body">Apologies for this, it's very embarrassing but an error has occurred, and I've been notified. Please navigate back to the <a href="/">home page</a> and start your journey again.</p>

			</div>
		</div>
	</div>

@stop
